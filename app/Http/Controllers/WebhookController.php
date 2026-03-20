<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use App\Models\Cart;
use App\Models\Subscription_plans;
use App\Models\User_subscriptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderReceiptMail;
use Stripe\Stripe;
use Carbon\Carbon;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $payload   = $request->getContent();
        $sigHeader = $request->server('HTTP_STRIPE_SIGNATURE');
        $secret    = config('services.stripe.webhook_secret');

        Log::info('🔥 Webhook received', ['payload_length' => strlen($payload)]);

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Webhook signature invalid', ['error' => $e->getMessage()]);
            return response('Invalid signature', 400);
        } catch (\Exception $e) {
            Log::error('Webhook error', ['error' => $e->getMessage()]);
            return response('Webhook error', 400);
        }

        Log::info('Webhook event received', ['type' => $event->type]);

        switch ($event->type) {

            // ── Handles BOTH single purchase AND subscription first payment ──
            case 'checkout.session.completed':
                $this->handleCheckoutCompleted($event->data->object);
                break;

            // ── Subscription created or upgraded ──
            case 'customer.subscription.created':
            case 'customer.subscription.updated':
                $this->handleSubscriptionUpdated($event->data->object);
                break;

            // ── Subscription renewal payment ──
            case 'invoice.payment_succeeded':
            case 'invoice.paid':
                $this->handlePaymentSucceeded($event->data->object);
                break;

            // ── Payment failed ──
            case 'invoice.payment_failed':
                $this->handlePaymentFailed($event->data->object);
                break;

            // ── Subscription fully cancelled/deleted ──
            case 'customer.subscription.deleted':
                $this->handleSubscriptionDeleted($event->data->object);
                break;

            default:
                Log::info('Unhandled webhook event', ['type' => $event->type]);
        }

        return response('Webhook handled', 200);
    }

    // =========================================================
    // SINGLE PURCHASE — checkout.session.completed
    // =========================================================
    private function handleCheckoutCompleted($session)
    {
        Log::info('handleCheckoutCompleted called', [
            'session_id'     => $session->id,
            'payment_status' => $session->payment_status,
            'mode'           => $session->mode,
            'email'          => $session->customer_email,
        ]);

        // ── Subscription checkout — handled by subscription webhooks ──
        if ($session->mode === 'subscription') {
            Log::info('Skipping — subscription mode handled by subscription webhooks');
            return;
        }

        // ── One-time payment only below ──
        if ($session->payment_status !== 'paid') {
            Log::warning('Payment not paid yet', ['status' => $session->payment_status]);
            return;
        }

        // Prevent duplicate orders
        if (Order::where('stripe_session_id', $session->id)->exists()) {
            Log::warning('Order already exists', ['session_id' => $session->id]);
            return;
        }

        // Get cart items from cache
        $cartData = Cache::get('stripe_cart_' . $session->id);

        Log::info('Cart data from cache', [
            'session_id' => $session->id,
            'found'      => $cartData ? 'YES' : 'NO',
            'items'      => $cartData ? count($cartData['items']) : 0,
        ]);

        if (!$cartData || empty($cartData['items'])) {
            Log::error('Cart data missing from cache', ['session_id' => $session->id]);
            return;
        }

        DB::beginTransaction();

        try {
            $user = User::where('email', $session->customer_email)->first();

            $order = Order::create([
                'user_id'           => $user?->id,
                'order_number'      => 'ORD-' . strtoupper(uniqid()),
                'total_amount'      => $session->amount_total / 100,
                'stripe_session_id' => $session->id,
                'email'             => $session->customer_email,
                'payment_status'    => 'paid',
                'order_status'      => 'completed',
            ]);

            Log::info('Order created', [
                'order_id'     => $order->id,
                'order_number' => $order->order_number,
            ]);

            foreach ($cartData['items'] as $item) {
                OrderDetail::create([
                    'order_id'   => $order->id,
                    'product_id' => $item['id'],
                    'price'      => $item['price'],
                    'qty'        => $item['qty'],
                ]);
            }

            // Clear cart

            if ($user) {
                $totalQty = collect($cartData['items'])->sum('qty');

                $activeSubscription = User_subscriptions::where('user_id', $user->id)
                    ->where('status', 'active')
                    ->where('end_date', '>', now())
                    ->latest()
                    ->first();

                if ($activeSubscription) {
                    $totalClips = $activeSubscription->total_clips;


                    if ($totalClips < $totalQty) {
                        Log::warning('⚠️ Not enough clips', [
                            'user_id'         => $user->id,
                            'total_clips'     => $totalClips,
                            'requested'       => $totalQty,
                        ]);
                        // Optional: you can block the order here or just allow it
                    } else {
                        $usedClips = min($totalQty, $activeSubscription->used_clips + $totalQty);
                        $remainingClips = max(0, $activeSubscription->remaining_clips - $totalQty);

                        $activeSubscription->update([
                            'used_clips' => $usedClips,
                            'remaining_clips' => $remainingClips,
                        ]);
                    }

                    Log::info('✅ Clips deducted', [
                        'user_id'         => $user->id,
                        'qty_deducted'    => $totalQty,
                        'used_clips'      => $activeSubscription->fresh()->used_clips,
                        'remaining_clips' => $activeSubscription->fresh()->remaining_clips,
                    ]);
                } else {
                    Log::warning('⚠️ No active subscription found for user', [
                        'user_id' => $user->id,
                    ]);
                }
            }
            if ($user) {
                Cart::where('user_id', $user->id)->delete();
                Log::info('DB cart cleared', ['user_id' => $user->id]);
            }

            Cache::forget('stripe_cart_' . $session->id);

            DB::commit();

            // Send receipt email
            try {
                $orderWithDetails = Order::with('order_details.product')->find($order->id);
                Mail::to($order->email)->send(new OrderReceiptMail($orderWithDetails));
                Log::info('Receipt email sent', ['email' => $order->email]);
            } catch (\Exception $mailException) {
                Log::error('Email failed', ['error' => $mailException->getMessage()]);
            }

            Log::info('✅ Order processing completed', ['order_id' => $order->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    // =========================================================
    // SUBSCRIPTION CREATED OR UPGRADED
    // customer.subscription.created / customer.subscription.updated
    // =========================================================
    private function handleSubscriptionUpdated($stripeSub)
    {
        Log::info('handleSubscriptionUpdated called', [
            'stripe_sub_id' => $stripeSub->id,
            'status'        => $stripeSub->status,
            'metadata'      => (array) $stripeSub->metadata,
        ]);

        // ✅ Always retrieve fresh — webhook object timestamps can be null
        try {
            $freshSub = \Stripe\Subscription::retrieve([
                'id'     => $stripeSub->id,
                'expand' => ['latest_invoice'],
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve subscription from Stripe', [
                'error' => $e->getMessage(),
            ]);
            return;
        }

        $planId = $freshSub->metadata->plan_id ?? $stripeSub->metadata->plan_id ?? null;
        $userId = $freshSub->metadata->user_id ?? $stripeSub->metadata->user_id ?? null;

        Log::info('Fresh subscription data', [
            'plan_id'              => $planId,
            'user_id'              => $userId,
            'current_period_start' => $freshSub->current_period_start,
            'current_period_end'   => $freshSub->current_period_end,
            'status'               => $freshSub->status,
        ]);

        $startDate = $freshSub->current_period_start
            ? Carbon::createFromTimestamp($freshSub->current_period_start)
            : now();

        $endDate = $freshSub->current_period_end
            ? Carbon::createFromTimestamp($freshSub->current_period_end)
            : $this->getFallbackEndDate($planId);

        Log::info('Dates resolved', [
            'start' => $startDate->toDateTimeString(),
            'end'   => $endDate->toDateTimeString(),
        ]);

        $dbSub = User_subscriptions::where('stripe_subscription_id', $freshSub->id)
            ->latest()
            ->first();

        // ── No record + has metadata = CREATE new subscription ──
        if (!$dbSub && $planId && $userId) {

            $plan = Subscription_plans::find($planId);
            if (!$plan) {
                Log::error('Plan not found', ['plan_id' => $planId]);
                return;
            }

            // Deactivate any existing active/cancelled subscriptions
            User_subscriptions::where('user_id', $userId)
                ->whereIn('status', ['active', 'cancelled'])
                ->update(['status' => 'inactive']);

            User_subscriptions::create([
                'user_id'                => $userId,
                'subscription_plan_id'   => $plan->id,
                'stripe_subscription_id' => $freshSub->id,
                'start_date'             => $startDate,
                'end_date'               => $endDate,
                'total_clips'            => $plan->total_clips,
                'used_clips'             => 0,
                'remaining_clips'        => $plan->total_clips,
                'amount'                 => $plan->price,
                'payment_gateway'        => 'stripe',
                'transaction_id'         => $freshSub->id,
                'payment_status'         => 'success',
                'status'                 => 'active',
            ]);

            Log::info('✅ Subscription CREATED in DB', [
                'user_id'    => $userId,
                'plan_id'    => $planId,
                'start_date' => $startDate->toDateTimeString(),
                'end_date'   => $endDate->toDateTimeString(),
            ]);
            return;
        }

        if (!$dbSub) {
            Log::warning('⚠️ No DB record and no metadata — cannot create', [
                'stripe_sub_id' => $freshSub->id,
            ]);
            return;
        }

        // ── Record exists = UPDATE dates and status ──
        $updateData = [
            'start_date' => $startDate,
            'end_date'   => $endDate,
        ];

        if ($freshSub->status === 'active') {
            $updateData['status']         = 'active';
            $updateData['payment_status'] = 'success';
        }

        if ($freshSub->cancel_at_period_end) {
            $updateData['status'] = 'cancelled';
        }

        $dbSub->update($updateData);

        Log::info('✅ Subscription UPDATED in DB', [
            'stripe_sub_id' => $freshSub->id,
            'start_date'    => $startDate->toDateTimeString(),
            'end_date'      => $endDate->toDateTimeString(),
        ]);
    }

    // =========================================================
    // SUBSCRIPTION RENEWAL
    // invoice.payment_succeeded / invoice.paid
    // =========================================================
    private function handlePaymentSucceeded($invoice)
    {
        $stripeSubId = $invoice->subscription ?? null;

        Log::info('handlePaymentSucceeded called', [
            'stripe_sub_id'  => $stripeSubId,
            'billing_reason' => $invoice->billing_reason ?? null,
        ]);

        // First payment is handled by customer.subscription.created
        if (!$stripeSubId || $invoice->billing_reason === 'subscription_create') {
            Log::info('Skipping — first payment handled by subscription.created');
            return;
        }

        // ✅ Fresh retrieve for accurate timestamps
        try {
            $freshSub = \Stripe\Subscription::retrieve($stripeSubId);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve subscription for renewal', [
                'error' => $e->getMessage(),
            ]);
            return;
        }

        $startDate = $freshSub->current_period_start
            ? Carbon::createFromTimestamp($freshSub->current_period_start)
            : now();

        $endDate = $freshSub->current_period_end
            ? Carbon::createFromTimestamp($freshSub->current_period_end)
            : now()->addMonth();

        $dbSub = User_subscriptions::where('stripe_subscription_id', $stripeSubId)
            ->latest()
            ->first();

        if (!$dbSub) {
            Log::warning('No DB record found for renewal', ['stripe_sub_id' => $stripeSubId]);
            return;
        }

        // Renewal — reset clips and update dates
        $dbSub->update([
            'start_date'      => $startDate,
            'end_date'        => $endDate,
            'used_clips'      => 0,
            'remaining_clips' => $dbSub->total_clips,
            'payment_status'  => 'success',
            'status'          => 'active',
        ]);

        Log::info('✅ Subscription RENEWED in DB', [
            'stripe_sub_id' => $stripeSubId,
            'start_date'    => $startDate->toDateTimeString(),
            'end_date'      => $endDate->toDateTimeString(),
        ]);
    }

    // =========================================================
    // PAYMENT FAILED
    // =========================================================
    private function handlePaymentFailed($invoice)
    {
        $stripeSubId = $invoice->subscription ?? null;

        if (!$stripeSubId) return;

        User_subscriptions::where('stripe_subscription_id', $stripeSubId)
            ->latest()
            ->first()
            ?->update([
                'status'         => 'payment_failed',
                'payment_status' => 'failed',
            ]);

        Log::warning('❌ Subscription payment failed', ['stripe_sub_id' => $stripeSubId]);
    }

    // =========================================================
    // SUBSCRIPTION DELETED / EXPIRED
    // =========================================================
    private function handleSubscriptionDeleted($stripeSub)
    {
        User_subscriptions::where('stripe_subscription_id', $stripeSub->id)
            ->latest()
            ->first()
            ?->update([
                'status'   => 'expired',
                'end_date' => now(),
            ]);

        Log::info('Subscription deleted/expired', ['stripe_sub_id' => $stripeSub->id]);
    }

    // =========================================================
    // HELPER — fallback end date based on plan type
    // =========================================================
    private function getFallbackEndDate($planId)
    {
        if (!$planId) return now()->addMonth();

        $plan = Subscription_plans::find($planId);
        if (!$plan) return now()->addMonth();

        return match (strtolower(trim($plan->duration_type))) {
            'month'   => now()->addMonth(),
            'quarter' => now()->addMonths(3),
            'year'    => now()->addYear(),
            default   => now()->addMonth(),
        };
    }
}

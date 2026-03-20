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

            case 'checkout.session.completed':
                $this->handleCheckoutCompleted($event->data->object);
                break;

            case 'customer.subscription.created':
            case 'customer.subscription.updated':
                $this->handleSubscriptionUpdated($event->data->object);
                break;

            case 'invoice.payment_succeeded':
            case 'invoice.paid':
                $this->handlePaymentSucceeded($event->data->object);
                break;

            case 'invoice.payment_failed':
                $this->handlePaymentFailed($event->data->object);
                break;

            case 'customer.subscription.deleted':
                $this->handleSubscriptionDeleted($event->data->object);
                break;

            default:
                Log::info('Unhandled webhook event', ['type' => $event->type]);
        }

        return response('Webhook handled', 200);
    }

    // =========================================================
    // ORDER HANDLER
    // =========================================================
    private function handleCheckoutCompleted($session)
    {
        Log::info('checkout.session.completed', [
            'session_id'     => $session->id,
            'payment_status' => $session->payment_status,
            'mode'           => $session->mode,
        ]);

        // Skip subscription checkouts — handled by subscription webhooks
        if ($session->mode === 'subscription') {
            Log::info('Skipping subscription checkout — handled by subscription webhook');
            return;
        }

        if ($session->payment_status !== 'paid') return;

        if (Order::where('stripe_session_id', $session->id)->exists()) {
            Log::warning('Order already exists', ['session_id' => $session->id]);
            return;
        }

        $cartData = Cache::get('stripe_cart_' . $session->id);
        if (!$cartData || empty($cartData['items'])) {
            Log::error('Cart data missing', ['session_id' => $session->id]);
            return;
        }

        DB::beginTransaction();
        try {
            $user  = User::where('email', $session->customer_email)->first();
            $order = Order::create([
                'user_id'           => $user?->id,
                'order_number'      => 'ORD-' . strtoupper(uniqid()),
                'total_amount'      => $session->amount_total / 100,
                'stripe_session_id' => $session->id,
                'email'             => $session->customer_email,
                'payment_status'    => 'paid',
                'order_status'      => 'completed',
            ]);

            foreach ($cartData['items'] as $item) {
                OrderDetail::create([
                    'order_id'   => $order->id,
                    'product_id' => $item['id'],
                    'price'      => $item['price'],
                    'qty'        => $item['qty'],
                ]);
            }

            if ($user) Cart::where('user_id', $user->id)->delete();
            Cache::forget('stripe_cart_' . $session->id);

            DB::commit();

            try {
                $orderWithDetails = Order::with('order_details.product')->find($order->id);
                Mail::to($order->email)->send(new OrderReceiptMail($orderWithDetails));
            } catch (\Exception $mailException) {
                Log::error('Email failed', ['error' => $mailException->getMessage()]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order creation failed', ['error' => $e->getMessage()]);
        }
    }

    // =========================================================
    // SUBSCRIPTION HANDLERS
    // =========================================================
    private function handleSubscriptionUpdated($stripeSub)
    {
        Log::info('handleSubscriptionUpdated called', [
            'stripe_sub_id' => $stripeSub->id,
            'status'        => $stripeSub->status,
            'metadata'      => (array) $stripeSub->metadata,
        ]);

        $planId = $stripeSub->metadata->plan_id ?? null;
        $userId = $stripeSub->metadata->user_id ?? null;

        $dbSub = User_subscriptions::where('stripe_subscription_id', $stripeSub->id)
            ->latest()->first();

        // ✅ No record + has metadata = CREATE
        if (!$dbSub && $planId && $userId) {

            $plan = Subscription_plans::find($planId);
            if (!$plan) {
                Log::error('Plan not found', ['plan_id' => $planId]);
                return;
            }

            // ✅ Safely handle null timestamps
            $startDate = $stripeSub->current_period_start
                ? Carbon::createFromTimestamp($stripeSub->current_period_start)
                : now();

            $endDate = $stripeSub->current_period_end
                ? Carbon::createFromTimestamp($stripeSub->current_period_end)
                : now()->addMonth();

            Log::info('Dates resolved', [
                'start' => $startDate->toDateTimeString(),
                'end'   => $endDate->toDateTimeString(),
            ]);

            User_subscriptions::where('user_id', $userId)
                ->whereIn('status', ['active', 'cancelled'])
                ->update(['status' => 'inactive']);

            User_subscriptions::create([
                'user_id'                => $userId,
                'subscription_plan_id'   => $plan->id,
                'stripe_subscription_id' => $stripeSub->id,
                'start_date'             => $startDate,
                'end_date'               => $endDate,
                'total_clips'            => $plan->total_clips,
                'used_clips'             => 0,
                'remaining_clips'        => $plan->total_clips,
                'amount'                 => $plan->price,
                'payment_gateway'        => 'stripe',
                'transaction_id'         => $stripeSub->id,
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
            Log::warning('⚠️ No DB record and no metadata — skipping', [
                'stripe_sub_id' => $stripeSub->id,
            ]);
            return;
        }

        // ✅ Record exists = UPDATE
        $updateData = [
            'start_date' => $stripeSub->current_period_start
                ? Carbon::createFromTimestamp($stripeSub->current_period_start)
                : now(),

            'end_date'   => $stripeSub->current_period_end
                ? Carbon::createFromTimestamp($stripeSub->current_period_end)
                : now()->addMonth(),
        ];

        if ($stripeSub->status === 'active') {
            $updateData['status']         = 'active';
            $updateData['payment_status'] = 'success';
        }

        if ($stripeSub->cancel_at_period_end) {
            $updateData['status'] = 'cancelled';
        }

        $dbSub->update($updateData);
        Log::info('✅ Subscription UPDATED in DB', ['stripe_sub_id' => $stripeSub->id]);
    }

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

        $stripeSub = \Stripe\Subscription::retrieve($stripeSubId);
        $dbSub     = User_subscriptions::where('stripe_subscription_id', $stripeSubId)
            ->latest()->first();

        if (!$dbSub) {
            Log::warning('No DB record found for renewal', ['stripe_sub_id' => $stripeSubId]);
            return;
        }

        // Renewal — reset clips and update dates
        $dbSub->update([
            'start_date'      => $stripeSub->current_period_start
                ? Carbon::createFromTimestamp($stripeSub->current_period_start)
                : now(),
            'end_date'        => $stripeSub->current_period_end
                ? Carbon::createFromTimestamp($stripeSub->current_period_end)
                : now()->addMonth(),
            'used_clips'      => 0,
            'remaining_clips' => $dbSub->total_clips,
            'payment_status'  => 'success',
            'status'          => 'active',
        ]);

        Log::info('✅ Subscription RENEWED in DB', ['stripe_sub_id' => $stripeSubId]);
    }

    private function handlePaymentFailed($invoice)
    {
        $stripeSubId = $invoice->subscription ?? null;
        if (!$stripeSubId) return;

        User_subscriptions::where('stripe_subscription_id', $stripeSubId)
            ->latest()->first()
            ?->update([
                'status'         => 'payment_failed',
                'payment_status' => 'failed',
            ]);

        Log::warning('❌ Subscription payment failed', ['stripe_sub_id' => $stripeSubId]);
    }

    private function handleSubscriptionDeleted($stripeSub)
    {
        User_subscriptions::where('stripe_subscription_id', $stripeSub->id)
            ->latest()->first()
            ?->update([
                'status'   => 'expired',
                'end_date' => $stripeSub->current_period_end
                    ? Carbon::createFromTimestamp($stripeSub->current_period_end)
                    : now(),
            ]);

        Log::info('Subscription deleted/expired', ['stripe_sub_id' => $stripeSub->id]);
    }
}

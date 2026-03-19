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

        Log::info('Webhook received');

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

            // ─── ORDER WEBHOOK ───────────────────────────────────────────
            case 'checkout.session.completed':
                $this->handleCheckoutCompleted($event->data->object);
                break;

            // ─── SUBSCRIPTION WEBHOOKS ───────────────────────────────────
            case 'customer.subscription.created':
            case 'customer.subscription.updated':
                $this->handleSubscriptionUpdated($event->data->object);
                break;

            case 'invoice.payment_succeeded':
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
    // ORDER HANDLERS
    // =========================================================

    private function handleCheckoutCompleted($session)
    {
        Log::info('checkout.session.completed', [
            'session_id'     => $session->id,
            'payment_status' => $session->payment_status,
            'email'          => $session->customer_email,
        ]);

        if ($session->payment_status !== 'paid') {
            Log::warning('Payment not paid yet', ['status' => $session->payment_status]);
            return;
        }

        // Prevent duplicate order
        if (Order::where('stripe_session_id', $session->id)->exists()) {
            Log::warning('Order already exists', ['session_id' => $session->id]);
            return;
        }

        // Get cart from cache
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

            if ($user) {
                Cart::where('user_id', $user->id)->delete();
                Log::info('DB cart cleared', ['user_id' => $user->id]);
            }

            Cache::forget('stripe_cart_' . $session->id);

            DB::commit();

            try {
                $orderWithDetails = Order::with('order_details.product')->find($order->id);
                Mail::to($order->email)->send(new OrderReceiptMail($orderWithDetails));
                Log::info('Receipt email sent', ['email' => $order->email]);
            } catch (\Exception $mailException) {
                Log::error('Email failed', ['error' => $mailException->getMessage()]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    // =========================================================
    // SUBSCRIPTION HANDLERS
    // =========================================================

    private function handleSubscriptionUpdated($stripeSub)
    {
        $dbSub = User_subscriptions::where('stripe_subscription_id', $stripeSub->id)
            ->latest()
            ->first();

        if (!$dbSub) return;

        $updateData = [
            'start_date' => Carbon::createFromTimestamp($stripeSub->current_period_start),
            'end_date'   => Carbon::createFromTimestamp($stripeSub->current_period_end),
        ];

        if ($stripeSub->status === 'active') {
            $updateData['status']         = 'active';
            $updateData['payment_status'] = 'success';
        }

        if ($stripeSub->cancel_at_period_end) {
            $updateData['status'] = 'cancelled';
        }

        $dbSub->update($updateData);

        Log::info('Subscription updated', ['stripe_sub_id' => $stripeSub->id]);
    }

    private function handlePaymentSucceeded($invoice)
    {
        $stripeSubId = $invoice->subscription;

        if (!$stripeSubId) return;

        // First payment — handled by subscription.created
        if ($invoice->billing_reason === 'subscription_create') return;

        $stripeSub = \Stripe\Subscription::retrieve($stripeSubId);

        $dbSub = User_subscriptions::where('stripe_subscription_id', $stripeSubId)
            ->latest()
            ->first();

        if (!$dbSub) return;

        $dbSub->update([
            'start_date'      => Carbon::createFromTimestamp($stripeSub->current_period_start),
            'end_date'        => Carbon::createFromTimestamp($stripeSub->current_period_end),
            'used_clips'      => 0,
            'remaining_clips' => $dbSub->total_clips,
            'payment_status'  => 'success',
            'status'          => 'active',
        ]);

        Log::info('Subscription renewed', ['stripe_sub_id' => $stripeSubId]);
    }

    private function handlePaymentFailed($invoice)
    {
        $stripeSubId = $invoice->subscription;

        if (!$stripeSubId) return;

        User_subscriptions::where('stripe_subscription_id', $stripeSubId)
            ->latest()
            ->first()
            ?->update([
                'status'         => 'past_due',
                'payment_status' => 'failed',
            ]);

        Log::warning('Subscription payment failed', ['stripe_sub_id' => $stripeSubId]);
    }

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
}

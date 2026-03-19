<?php

namespace App\Http\Controllers;

use App\Models\Subscription_plans;
use App\Models\User_subscriptions;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Carbon\Carbon;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $payload   = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret    = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        switch ($event->type) {

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
        }

        return response()->json(['status' => 'ok'], 200);
    }

    // ✅ Fired on subscription create/update — always sync dates from Stripe
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

        // Stripe marks cancel_at_period_end when user cancels but still has access
        if ($stripeSub->cancel_at_period_end) {
            $updateData['status'] = 'cancelled';
        }

        $dbSub->update($updateData);
    }

    // ✅ Fired on every successful payment (first payment + renewals)
    private function handlePaymentSucceeded($invoice)
    {
        $stripeSubId = $invoice->subscription;

        if (!$stripeSubId) return;

        // Skip if it's not a subscription invoice (e.g. one-time payment)
        if ($invoice->billing_reason === 'subscription_create') {
            // First payment — dates already handled by subscription.created
            return;
        }

        // Renewal — retrieve fresh subscription to get new period dates
        $stripeSub = \Stripe\Subscription::retrieve($stripeSubId);

        $dbSub = User_subscriptions::where('stripe_subscription_id', $stripeSubId)
            ->latest()
            ->first();

        if (!$dbSub) return;

        // Reset clips and update dates for new billing period
        $dbSub->update([
            'start_date'      => Carbon::createFromTimestamp($stripeSub->current_period_start),
            'end_date'        => Carbon::createFromTimestamp($stripeSub->current_period_end),
            'used_clips'      => 0,
            'remaining_clips' => $dbSub->total_clips,
            'payment_status'  => 'success',
            'status'          => 'active',
        ]);
    }

    // ❌ Fired when payment fails
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
    }

    // 🚫 Fired when subscription fully expires/deleted (after cancel_at_period_end passes)
    private function handleSubscriptionDeleted($stripeSub)
    {
        User_subscriptions::where('stripe_subscription_id', $stripeSub->id)
            ->latest()
            ->first()
            ?->update([
                'status'   => 'expired',
                'end_date' => now(),
            ]);
    }
}

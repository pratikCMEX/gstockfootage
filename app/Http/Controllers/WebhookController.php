<?php

namespace App\Http\Controllers;

use App\Models\Subscription_plans;
use App\Models\User_subscriptions;
use Illuminate\Http\Request;
use Stripe\Stripe;

class WebhookController extends Controller
{
    // app/Http/Controllers/WebhookController.php

    public function handle(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        match ($event->type) {

            // ✅ Fired on every successful renewal
            'invoice.payment_succeeded' => $this->handleRenewal($event->data->object),

            // ❌ Fired when renewal payment fails
            'invoice.payment_failed'    => $this->handleFailed($event->data->object),

            // 🚫 Fired when user cancels
            'customer.subscription.deleted' => $this->handleCancelled($event->data->object),

            default => null,
        };

        return response()->json(['status' => 'ok']);
    }

    private function handleRenewal($invoice)
    {
        $stripeSubId = $invoice->subscription;

        $sub = User_subscriptions::where('stripe_subscription_id', $stripeSubId)->first();

        if (!$sub) return;

        // ✅ Don't renew if user cancelled
        if ($sub->status === 'cancelled') return;

        $plan = Subscription_plans::find($sub->subscription_id);

        $newEndDate = match ($plan->duration_type) {
            'Month'   => now()->addMonths($plan->duration_value),
            'Quarter' => now()->addMonths($plan->duration_value * 3),
            'Year'    => now()->addYears($plan->duration_value),
            default   => now()->addMonth(),
        };

        $sub->update([
            'start_date' => now(),
            'end_date'   => $newEndDate,
            'status'     => 'active',
        ]);
    }


    // ✅ Stripe fires this when cancel_at_period_end finally expires
    private function handleCancelled($stripeSubscription)
    {
        User_subscriptions::where('stripe_subscription_id', $stripeSubscription->id)
            ->update([
                'status'     => 'expired',
                'end_date'   => now(),   // access fully cut off now
            ]);
    }

    private function handleFailed($invoice)
    {
        $stripeSubId = $invoice->subscription;

        User_subscriptions::where('stripe_subscription_id', $stripeSubId)
            ->update(['status' => 'payment_failed']);
    }


    public function subscriptionWebhook(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $payload    = $request->getContent();
        $sigHeader  = $request->header('Stripe-Signature');
        $secret     = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        switch ($event->type) {

            // ✅ First payment succeeded — activate subscription
            case 'invoice.payment_succeeded':
                $invoice      = $event->data->object;
                $stripeSubId  = $invoice->subscription;

                if (!$stripeSubId) break;

                $stripeSub = \Stripe\Subscription::retrieve($stripeSubId);
                $dbSub     = User_subscriptions::where('stripe_subscription_id', $stripeSubId)
                    ->where('status', 'active')
                    ->latest()
                    ->first();

                if ($dbSub) {
                    // Renewal — update dates and reset clips
                    $dbSub->update([
                        'start_date'      => \Carbon\Carbon::createFromTimestamp($stripeSub->current_period_start),
                        'end_date'        => \Carbon\Carbon::createFromTimestamp($stripeSub->current_period_end),
                        'used_clips'      => 0,
                        'remaining_clips' => $dbSub->total_clips,
                        'payment_status'  => 'success',
                        'status'          => 'active',
                    ]);
                }
                break;

            // ✅ Subscription created — set correct dates
            case 'customer.subscription.created':
            case 'customer.subscription.updated':
                $stripeSub   = $event->data->object;
                $stripeSubId = $stripeSub->id;

                $dbSub = User_subscriptions::where('stripe_subscription_id', $stripeSubId)
                    ->latest()
                    ->first();

                if ($dbSub) {
                    $updateData = [
                        'start_date' => \Carbon\Carbon::createFromTimestamp($stripeSub->current_period_start),
                        'end_date'   => \Carbon\Carbon::createFromTimestamp($stripeSub->current_period_end),
                    ];

                    // If stripe says active, make sure DB reflects it
                    if ($stripeSub->status === 'active') {
                        $updateData['status'] = 'active';
                    }

                    $dbSub->update($updateData);
                }
                break;

            // ❌ Payment failed — mark as past_due
            case 'invoice.payment_failed':
                $invoice     = $event->data->object;
                $stripeSubId = $invoice->subscription;

                if (!$stripeSubId) break;

                User_subscriptions::where('stripe_subscription_id', $stripeSubId)
                    ->where('status', 'active')
                    ->update(['status' => 'past_due', 'payment_status' => 'failed']);
                break;

            // 🚫 Subscription cancelled
            case 'customer.subscription.deleted':
                $stripeSub   = $event->data->object;
                $stripeSubId = $stripeSub->id;

                User_subscriptions::where('stripe_subscription_id', $stripeSubId)
                    ->update(['status' => 'inactive']);
                break;
        }

        return response()->json(['status' => 'ok'], 200);
    }
}

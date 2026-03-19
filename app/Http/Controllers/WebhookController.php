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
}

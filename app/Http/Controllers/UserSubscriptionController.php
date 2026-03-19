<?php

namespace App\Http\Controllers;

use App\Models\Subscription_plans;
use App\Models\User_subscriptions;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class UserSubscriptionController extends Controller
{
    public function checkout($id)
    {
        $plan = Subscription_plans::findOrFail($id);

        return view('front.subscription_checkout', compact('plan'));
    }
    public function stripeSessionOld(Request $request)
    {

        $plan = Subscription_plans::findOrFail($request->plan_id);

        $existingSubscription = User_subscriptions::where('user_id', auth()->id())
            ->where('status', 'active')
            ->where('end_date', '>', now())
            ->first();

        if ($existingSubscription) {
            return redirect()->route('pricing')->with('msg_error', 'You already have an active subscription.');
            // return back()->with('error', 'You already have an active subscription.');
        }



        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([

            'payment_method_types' => ['card'],

            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $plan->name,
                        ],
                        'unit_amount' => $plan->price * 100,
                    ],
                    'quantity' => 1,
                ]
            ],

            'mode' => 'payment',

            'success_url' => route('subscription.success') . '?plan=' . $plan->id,
            'cancel_url' => route('subscription.cancel'),

        ]);

        return redirect($session->url);
    }

    public function stripeSession(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $plan = Subscription_plans::findOrFail($request->plan_id);
        $user = auth()->user();

        // Check if user has an active subscription
        $existingSubscription = User_subscriptions::where('user_id', $user->id)
            ->whereIn('status', ['active', 'cancelled'])
            ->where('end_date', '>', now())
            ->latest()
            ->first();

        // ✅ If already has active sub → upgrade directly (no checkout)
        if ($existingSubscription && $existingSubscription->stripe_subscription_id) {
            return $this->upgradeSubscription($existingSubscription, $plan, $user);
        }

        // No existing sub → normal checkout flow
        if (!$user->stripe_customer_id) {
            $customer = \Stripe\Customer::create([
                'email' => $user->email,
                'name'  => $user->first_name . ' ' . $user->last_name,
            ]);
            $user->update(['stripe_customer_id' => $customer->id]);
        }

        $session = Session::create([
            'customer'             => $user->stripe_customer_id,
            'payment_method_types' => ['card'],
            'line_items'           => [[
                'price'    => $plan->stripe_price_id,
                'quantity' => 1,
            ]],
            'mode'        => 'subscription',
            'success_url' => route('subscription.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('pricing'),
            'metadata'    => [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
            ],
        ]);

        return redirect($session->url);
    }

    private function upgradeSubscription($existingSubscription, $newPlan, $user)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // Get current Stripe subscription
            $stripeSub = \Stripe\Subscription::retrieve(
                $existingSubscription->stripe_subscription_id
            );

            // ✅ Update Stripe subscription to new price
            // proration_behavior: 'create_prorations' = charges difference immediately
            $updatedSub = \Stripe\Subscription::update(
                $existingSubscription->stripe_subscription_id,
                [
                    'cancel_at_period_end' => false, // in case they had cancelled
                    'proration_behavior'   => 'create_prorations',
                    'items'                => [[
                        'id'    => $stripeSub->items->data[0]->id,
                        'price' => $newPlan->stripe_price_id,
                    ]],
                    'metadata' => [
                        'user_id' => $user->id,
                        'plan_id' => $newPlan->id,
                    ],
                ]
            );

            // Calculate new end date
            $startDate  = now();
            $type       = strtolower(trim($newPlan->duration_type));
            $value      = $newPlan->duration_value;

            $endDate = match ($type) {
                'month'   => now()->addMonths($value),
                'quarter' => now()->addMonths($value * 3),
                'year'    => now()->addYears($value),
                default   => now()->addMonth(),
            };

            // Deactivate old subscription in DB
            $existingSubscription->update(['status' => 'inactive']);

            $endDate = \Carbon\Carbon::createFromTimestamp($updatedSub->current_period_end);

            // Create new subscription record
            User_subscriptions::create([
                'user_id'                => $user->id,
                'subscription_plan_id'   => $newPlan->id,
                'stripe_subscription_id' => $updatedSub->id, // same stripe sub ID
                'start_date'             => \Carbon\Carbon::createFromTimestamp($updatedSub->current_period_start),
                'end_date'               => $endDate,
                'total_clips'            => $newPlan->total_clips,
                'used_clips'             => 0,
                'remaining_clips'        => $newPlan->total_clips,
                'amount'                 => $newPlan->price,
                'payment_gateway'        => 'stripe',
                'transaction_id'         => $updatedSub->id,
                'payment_status'         => 'success',
                'status'                 => 'active',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('pricing')
                ->with('msg_error', 'Upgrade failed: ' . $e->getMessage());
        }

        return redirect()->route('user.profile')
            ->with('msg_success', 'Plan upgraded successfully!');
    }

    public function successOld(Request $request)
    {

        $plan = Subscription_plans::findOrFail($request->plan);

        $startDate = now();

        $type = strtolower(trim($plan->duration_type));
        $value = $plan->duration_value;

        switch ($type) {

            case 'month':
                $endDate = now()->addMonths($value);
                break;

            case 'quarter':
                $endDate = now()->addMonths($value * 3);
                break;

            case 'year':
                $endDate = now()->addYears($value);
                break;

            default:
                $endDate = now();
        }

        User_subscriptions::create([

            'user_id' => auth()->id(),
            'subscription_plan_id' => $plan->id,

            'start_date' => $startDate,
            'end_date' => $endDate,

            'total_clips' => $plan->total_clips,
            'used_clips' => 0,
            'remaining_clips' => $plan->total_clips,

            'amount' => $plan->price,

            'payment_gateway' => 'stripe',
            'transaction_id' => 'STRIPE_' . rand(100000, 999999),

            'payment_status' => 'success',
            'status' => 'active'

        ]);

        return redirect()->route('pricing')->with('msg_success', 'Subscription activated successfully');
    }

    public function success(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $session             = Session::retrieve($request->session_id);
        $stripeSubscription  = \Stripe\Subscription::retrieve($session->subscription);
        $plan                = Subscription_plans::findOrFail($session->metadata->plan_id);

        // Use Stripe dates if available, else fallback
        $startDate = $stripeSubscription->current_period_start
            ? \Carbon\Carbon::createFromTimestamp($stripeSubscription->current_period_start)
            : now();

        $endDate = $stripeSubscription->current_period_end
            ? \Carbon\Carbon::createFromTimestamp($stripeSubscription->current_period_end)
            : now()->addMonth();

        User_subscriptions::where('user_id', auth()->id())
            ->where('status', 'active')
            ->update(['status' => 'inactive']);

        User_subscriptions::create([
            'user_id'                => auth()->id(),
            'subscription_plan_id'   => $plan->id,
            'stripe_subscription_id' => $stripeSubscription->id,
            'start_date'             => $startDate,
            'end_date'               => $endDate,
            'total_clips'            => $plan->total_clips,
            'used_clips'             => 0,
            'remaining_clips'        => $plan->total_clips,
            'amount'                 => $plan->price,
            'payment_gateway'        => 'stripe',
            'transaction_id'         => $stripeSubscription->id,
            'payment_status'         => 'success',
            'status'                 => 'active',
        ]);

        return redirect()->route('pricing')
            ->with('msg_success', 'Subscription activated successfully');
    }

    public function cancelSubscription(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $userSubscription = User_subscriptions::where('user_id', auth()->id())
            ->where('status', 'active')
            ->latest()
            ->first();

        if (!$userSubscription) {
            return redirect()->back()->with('msg_error', 'No active subscription found.');
        }

        try {
            // ✅ Cancel at period end — user keeps access till end_date
            $stripeSubscription = \Stripe\Subscription::update(
                $userSubscription->stripe_subscription_id,
                ['cancel_at_period_end' => true]
            );

            // Mark as cancelled in DB but keep end_date intact
            $userSubscription->update([
                'status' => 'cancelled',   // stopped auto-renewal
                // end_date stays the same — they keep access till then
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('msg_error', 'Failed to cancel: ' . $e->getMessage());
        }

        return redirect()->route('profile')
            ->with('msg_success', 'Subscription cancelled. You have access until ' .
                $userSubscription->end_date->format('M d, Y'));
    }
    public function cancel()
    {
        return redirect()->route('pricing')->with('msg_error', 'Payment cancelled');
    }
}

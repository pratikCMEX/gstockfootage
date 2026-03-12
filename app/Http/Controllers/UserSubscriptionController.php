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
    public function stripeSession(Request $request)
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

    public function success(Request $request)
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
    public function cancel()
    {
        return redirect()->route('pricing')->with('msg_error', 'Payment cancelled');

    }
}

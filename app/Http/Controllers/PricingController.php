<?php

namespace App\Http\Controllers;

use App\Models\License_master;
use App\Models\Subscription_plans;
use App\Models\User_subscriptions;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function pricing()
    {
        $title = 'Videos';
        $page = 'front.pricing';
        $js = ['pricing'];

        $priceList = License_master::withExists([
            'userLicences as is_purchased' => function ($query) {
                $query->where('user_id', auth()->id());
            }
        ])
            ->get();

        // $subscriptionPlanList = Subscription_plans::where('is_active', '1')->get();
        // $subscriptionPlanList = Subscription_plans::where('is_active', '1')
        //     ->withExists([
        //         'userSubscriptions as is_purchased' => function ($query) {
        //             $query->where('user_id', auth()->id())
        //                 ->where('status', 'active')
        //                 ->where('end_date', '>', now());
        //         }
        //     ])
        //     ->get();

        $activeSubscription = null;
        $activePlan = null;

        if (auth()->check()) {
            $activeSubscription = User_subscriptions::with('plan')  // ✅ eager load
                ->where('user_id', auth()->id())
                ->whereIn('status', ['active', 'cancelled'])
                ->where('end_date', '>', now())
                ->latest()
                ->first();

            $activePlan = $activeSubscription?->plan ?? null;
        }

        $subscriptionPlanList = Subscription_plans::where('is_active', '1')
            ->orderBy('price', 'asc')
            ->get()
            ->map(function ($plan) use ($activeSubscription, $activePlan) {

                $plan->is_purchased   = false;
                $plan->is_lower_plan  = false;
                $plan->is_higher_plan = false;

                if ($activeSubscription && $activePlan) {

                    if ($activeSubscription->subscription_plan_id == $plan->id) {
                        $plan->is_purchased = true;
                    } elseif ($plan->price < $activePlan->price) {
                        $plan->is_lower_plan = true;
                    } elseif ($plan->price > $activePlan->price) {
                        $plan->is_higher_plan = true;
                    }
                }

                return $plan;
            });

        return view("layouts.front.layout", compact('title', 'page', 'js', 'priceList', 'subscriptionPlanList', 'currentPrice'));
    }
}

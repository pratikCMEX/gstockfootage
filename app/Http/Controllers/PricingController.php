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

        $currentSub = User_subscriptions::where('user_id', auth()->id())
            ->where('status', 'active')
            ->where('end_date', '>', now())
            ->with('subscription')
            ->latest()
            ->first();

        $currentPrice = $currentSub?->subscription?->price ?? 0;

        $subscriptionPlanList = Subscription_plans::all()->map(function ($plan) use ($currentSub, $currentPrice) {

            // Mark as current plan
            $plan->is_purchased = ($currentSub && $currentSub->subscription_plan_id == $plan->id) ? '1' : '0';

            // Mark as higher plan (upgrade option)
            $plan->is_higher_plan = $currentSub && $plan->price > $currentPrice;

            return $plan;
        });

        return view("layouts.front.layout", compact('title', 'page', 'js', 'priceList', 'subscriptionPlanList', 'currentPrice'));
    }
}

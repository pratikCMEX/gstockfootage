<?php

namespace App\Http\Controllers;

use App\Models\License_master;
use App\Models\Subscription_plans;
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
        $subscriptionPlanList = Subscription_plans::where('is_active', '1')
            ->withExists([
                'userSubscriptions as is_purchased' => function ($query) {
                    $query->where('user_id', auth()->id())
                        ->where('status', 'active')
                        ->where('end_date', '>', now());
                }
            ])
            ->get();

        return view("layouts.front.layout", compact('title', 'page', 'js', 'priceList', 'subscriptionPlanList'));
    }




}

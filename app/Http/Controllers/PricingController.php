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

        $priceList = License_master::get();

        $subscriptionPlanList = Subscription_plans::get();
        return view("layouts.front.layout", compact('title', 'page', 'js', 'priceList', 'subscriptionPlanList'));
    }




}

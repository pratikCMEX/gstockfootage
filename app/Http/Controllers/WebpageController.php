<?php

namespace App\Http\Controllers;

use App\Models\WebPages;
use Illuminate\Http\Request;

class WebpageController extends Controller
{
    public function term()
    {
        $title = 'Home';
        $page = 'front.term';
        $js = ['term'];
         $terms_services = WebPages::where('type','1')->get();
     
        return view("layouts.front.layout", compact('title', 'terms_services','page', 'js'));
    }
    public function privacy()
    {
        $title = 'Home';
        $page = 'front.privacy';
        // $js = ['privacy'];
       
        $privacy_policy = WebPages::where('type','0')->get();
     
        // $subscriptionPlanList=Subscription_plans::get();
        return view("layouts.front.layout", compact('title', 'page',  'privacy_policy'));
    }
}

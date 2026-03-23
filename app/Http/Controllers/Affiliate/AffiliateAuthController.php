<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use App\Models\AffiliateReferral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AffiliateAuthController extends Controller
{
    public function dashboard()
    {
        $title = 'Dashboard';
        $page = 'affiliate.dashboard';
        $affiliate_user = Auth::guard('affiliate')->user();
        $affiliate = $affiliate_user->affiliate;

        // Affiliate specific data
        $refferal_user_count = \App\Models\AffiliateReferral::whereHas('affiliate', function ($q) use ($affiliate_user) {
            $q->where('affiliate_user_id', $affiliate_user->id);
        })->count();

        // Basic counts (for dashboard display)
        $totalUser = \App\Models\User::count();
        $totalVideo = \App\Models\BatchFile::where('type', 'video')->count();
        $totalImage = \App\Models\BatchFile::where('type', 'image')->count();
        $totalCategory = \App\Models\Category::count();
        $totalProduct = \App\Models\BatchFile::count();
        $totalSubscription = \App\Models\Subscription_plans::count();

        // Orders summary
        $totalOrder = \App\Models\Order::count();
        $completedOrders = \App\Models\Order::where('order_status', 'completed')->count();
        $pendingOrders = \App\Models\Order::where('order_status', 'pending')->count();
        $totalRevenue = \App\Models\Order::where('payment_status', 'paid')->sum('total_amount');
        $todaySales = \App\Models\Order::where('payment_status', 'paid')
            ->whereDate('created_at', today())
            ->sum('total_amount');

        // Recent orders
        $recentOrders = \App\Models\Order::latest()->take(5)->get();

        return view('layouts.admin.layout', compact(
            'title',
            'page',
            'refferal_user_count',
            'totalUser',
            'totalVideo',
            'totalImage',
            'totalCategory',
            'totalProduct',
            'totalSubscription',
            'totalOrder',
            'completedOrders',
            'pendingOrders',
            'totalRevenue',
            'todaySales',
            'recentOrders'
        ));
    }

    public function referrals()
    {
        $affiliate = Auth::guard('affiliate')->user()->affiliate;
        $referrals = $affiliate->referrals()->with('user')->latest()->get();

        return view('affiliate.referrals', compact('affiliate', 'referrals'));
    }

    public function logout(Request $request)
    {
        Auth::guard('affiliate')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('msg_success', 'Logged out successfully.');
    }
}

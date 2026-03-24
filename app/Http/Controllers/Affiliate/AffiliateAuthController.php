<?php

namespace App\Http\Controllers\Affiliate;

use App\DataTables\CommissionHistoryDataTable;
use App\DataTables\PendingPaymentsDataTable;
use App\DataTables\RaferralUsersListDataTable;
use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use App\Models\AffiliateReferral;
use App\Models\AffiliateUser;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AffiliateAuthController extends Controller
{

    public function dashboard()
    {
        $title = 'Dashboard';
        $page = 'affiliate.dashboard';
        $affiliateUser = Auth::guard('affiliate')->user();
        $affiliate = $affiliateUser->affiliate;

        //  Total referred users count
        $totalReferredUsers = \App\Models\User::where('referred_by', $affiliate->referral_code)->count();

        //  Total commission earnings
        $totalEarnings = $affiliate->total_earnings ?? 0;
        $totalReferrals = $affiliate->total_referrals ?? 0;

        // Pending and paid amounts
        $pendingAmount = \App\Models\AffiliateReferral::where('affiliate_id', $affiliate->id)
            ->where('status', 'pending')
            ->sum('commission_amount');

        $paidAmount = \App\Models\AffiliateReferral::where('affiliate_id', $affiliate->id)
            ->where('status', 'paid')
            ->sum('commission_amount');

        //  Commission info
        $commissionInfo = $affiliate->commission_type === 'fixed'
            ? '$' . number_format($affiliate->commission_value, 2) . ' per order'
            : $affiliate->commission_value . '% per order';

        $referralLink = url('/') . '?ref=' . $affiliate->referral_code;

        //  Recent referral commissions
        $recentReferrals = \App\Models\AffiliateReferral::where('affiliate_id', $affiliate->id)
            ->with(['user', 'order'])
            ->latest()
            ->take(5)
            ->get();

        //  Today's earnings
        $todayEarnings = \App\Models\AffiliateReferral::where('affiliate_id', $affiliate->id)
            ->whereDate('created_at', today())
            ->sum('commission_amount');
        return view('layouts.admin.layout', compact(
            'title',
            'page',
            'affiliateUser',
            'affiliate',
            'totalReferredUsers', //  count of users who registered via this affiliate's link
            'totalEarnings',
            'totalReferrals',
            'pendingAmount',
            'paidAmount',
            'commissionInfo',
            'referralLink',
            'recentReferrals',
            'todayEarnings'
        ));

    }
    public function dashboard_old()
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

    public function referrals(RaferralUsersListDataTable $DataTable)
    {


        $title = 'Raferral Users List';
        $page = 'affiliate.referral_user_list';
        $js = [''];
        $affiliateUser = Auth::guard('affiliate')->user();
        $affiliate = $affiliateUser->affiliate;
        return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js', 'affiliate', 'affiliateUser'));
    }
    public function commission_history(CommissionHistoryDataTable $DataTable)
    {


        $title = 'Commission History';
        $page = 'affiliate.commission_history';
        $js = [''];
        $affiliateUser = Auth::guard('affiliate')->user();
        $affiliate = $affiliateUser->affiliate;
        return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js', 'affiliate', 'affiliateUser'));
    }
    public function pending_payments(PendingPaymentsDataTable $DataTable)
    {
        $title = 'Commission History';
        $page = 'affiliate.pending_payment_list';
        $js = [''];
        $affiliateUser = Auth::guard('affiliate')->user();
        $affiliate = $affiliateUser->affiliate;
  
        $totalPending = \App\Models\AffiliateReferral::where('affiliate_id', $affiliate->id)
            ->where('status', 'pending')
            ->sum('commission_amount');

        $totalCount = \App\Models\AffiliateReferral::where('affiliate_id', $affiliate->id)
            ->where('status', 'pending')
            ->count();

        return $DataTable->render('layouts.admin.layout', compact(
            'title',
            'page',
            'js',
            'affiliateUser',
            'affiliate',
            'totalPending',
            'totalCount'
        ));

    }


    
    
    public function logout(Request $request)
    {
        Auth::guard('affiliate')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('msg_success', 'Logged out successfully.');
    }
}

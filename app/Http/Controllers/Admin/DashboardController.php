<?php
/* ============================================================
   app/Http/Controllers/Admin/DashboardController.php
   ============================================================ */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BatchFile;
use App\Models\Category;
use App\Models\License_master;
use App\Models\Order;
use App\Models\Subscription_plans;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        $page  = 'admin.dashboard';

        /* ── Basic counts ── */
        $totalUser         = User::count();
        $totalVideo        = BatchFile::where('type', 'video')->count();
        $totalImage        = BatchFile::where('type', 'image')->count();
        $totalCategory     = Category::count();
        $totalProduct      = BatchFile::count();
        $totalLicense      = License_master::count();
        $totalSubscription = Subscription_plans::count();

        /* ── Orders summary ── */
        $totalOrder      = Order::count();
        $completedOrders = Order::where('order_status', 'completed')->count();
        $pendingOrders   = Order::where('order_status', 'pending')->count();
        $totalRevenue    = Order::where('payment_status', 'paid')->sum('total_amount');
        $todaySales      = Order::where('payment_status', 'paid')
            ->whereDate('created_at', today())
            ->sum('total_amount');

        /* ── Recent orders (last 10) ── */
        $recentOrders = Order::latest()->take(10)->get();

        /* ── Recent batch files (last 10) ── */
        $recentFiles = BatchFile::latest()->take(10)->get();

        /* ── Orders sparkline — last 10 days ── */
        $ordersTrend = collect(range(9, 0))->map(function ($d) {
            return Order::whereDate('created_at', today()->subDays($d))->count();
        })->values()->toArray();

        /* ── Monthly revenue — last 6 months ── */
        $monthlyRevenue = [];
        $monthlyLabels  = [];
        for ($i = 5; $i >= 0; $i--) {
            $month            = Carbon::now()->subMonths($i);
            $monthlyLabels[]  = $month->format('M');
            $monthlyRevenue[] = (float) Order::where('payment_status', 'paid')
                ->whereYear('created_at',  $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_amount');
        }

        /* ── Top categories by file count ── */
        $raw = DB::table('batch_files')
            ->join('categories', 'batch_files.category_id', '=', 'categories.id')
            ->select('categories.category_name', DB::raw('count(*) as total'))
            ->groupBy('categories.category_name')
            ->orderByDesc('total')
            ->take(6)
            ->get();
        $categoryLabels = $raw->pluck('category_name')->toArray();
        $categoryCounts = $raw->pluck('total')->toArray();

        /* ── Subscription plans ── */
        $subscriptionStats = Subscription_plans::where('is_active', '1')->get();

        $planNames  = $subscriptionStats->pluck('name')->toArray();
        $planPrices = $subscriptionStats->pluck('price')->map(fn($p) => (float) $p)->toArray();
        $planList   = $subscriptionStats->map(function ($p) {
            return [
                'name'   => $p->name,
                'clips'  => $p->total_clips ?? 0,
                'price'  => '$' . number_format($p->price, 2) . '/mo',
                'active' => $p->is_active === '1',
            ];
        })->toArray();

        return view('layouts.admin.layout', compact(
            'title',
            'page',
            'totalUser',
            'totalVideo',
            'totalImage',
            'totalCategory',
            'totalProduct',
            'totalLicense',
            'totalSubscription',
            'totalOrder',
            'completedOrders',
            'pendingOrders',
            'totalRevenue',
            'todaySales',
            'recentOrders',
            'recentFiles',
            'ordersTrend',
            'monthlyRevenue',
            'monthlyLabels',
            'categoryLabels',
            'categoryCounts',
            'subscriptionStats',
            'planNames',
            'planPrices',
            'planList'
        ));
    }
}

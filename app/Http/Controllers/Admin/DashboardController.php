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
use App\Models\User_subscriptions;
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
        $recentOrders = Order::latest()->take(5)->get();

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
            $month = Carbon::now()->startOfMonth()->subMonths($i); // 👈 key fix
            $monthlyLabels[] = $month->format('M') . "\n" . $month->format('Y');
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




        /* ── Recent activity (last 10 events combined) ── */
        $recentActivity = collect();

        // New users
        User::latest()->take(5)->get()->each(function ($u) use (&$recentActivity) {
            $recentActivity->push([
                'type'    => 'user',
                'title'   => 'New user registered',
                'sub'     => $u->first_name . ' ' . $u->last_name . ' · ' . $u->email,
                'dot'     => 'blue',
                'icon'    => '<i class="fa-solid fa-user"></i>',
                'time'    => $u->created_at,
            ]);
        });

        // New orders
        // Order::latest()->take(5)->get()->each(function ($o) use (&$recentActivity) {
        //     $recentActivity->push([
        //         'type'    => 'order',
        //         'title'   => 'New order placed',
        //         'sub'     => 'Order #' . $o->order_number . ' · $' . number_format($o->total_amount, 2),
        //         'dot'     => 'green',
        //         'icon'    => '<i class="fa-solid fa-cart-shopping"></i>',
        //         'time'    => $o->created_at,
        //     ]);
        // });

        // New subscriptions
        User_subscriptions::with(['user', 'subscription'])->latest()->take(5)->get()->each(function ($s) use (&$recentActivity) {
            $recentActivity->push([
                'type'    => 'subscription',
                'title'   => 'Subscription activated',
                'sub'     => ($s->user->first_name ?? 'User') . ' · ' . ($s->subscription->name ?? 'Plan'),
                'dot'     => 'purple',
                'icon'    => '<i class="fa-solid fa-crown"></i>',
                'time'    => $s->created_at,
            ]);
        });

        // New uploads
        BatchFile::latest()->take(5)->get()->each(function ($f) use (&$recentActivity) {
            $recentActivity->push([
                'type'    => 'upload',
                'title'   => ucfirst($f->type ?? 'File') . ' uploaded',
                'sub'     => basename($f->file_name ?? $f->file_path ?? 'Unknown file'),
                'dot'     => 'red',
                'icon'    => '<i class="fa-solid fa-film"></i>',
                'time'    => $f->created_at,
            ]);
        });

        // Sort all by time desc, take 10
        $recentActivity = $recentActivity
            ->sortByDesc('time')
            ->take(5)
            ->values();

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
            'planList',
            'recentActivity'
        ));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\LiveCartReportDataTable;
use App\DataTables\MostSoldProductReportDataTable;
use App\DataTables\MostViewedProductsReportDataTable;
use App\DataTables\OrderHistoryDataTable;
use App\DataTables\UserSubscriptionReportDataTable;
use App\DataTables\UserWiseOrderReportDataTable;
use App\Http\Controllers\Controller;
use App\Models\BatchFile;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use App\Models\User_subscriptions;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function order_history(OrderHistoryDataTable $DataTable)
    {
        $title = 'Order History';
        $page = 'admin.reports.order_history';
        $js = ['reports'];
        $css = 'reports';
        return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js', 'css'));

    }

    public function exportOrderPdf(Request $request)
    {
        $query = Order::select('orders.*');

        //  Apply same filters as DataTable
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        if ($request->filled('order_status')) {
            $query->where('order_status', $request->order_status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('admin.exports.order_history_pdf', compact('orders'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('OrderHistory_' . date('YmdHis') . '.pdf');
    }
    public function detail(string $id)
    {

        $id = decrypt($id);

        $order = Order::with(['user', 'order_details.product'])->findOrFail($id);

        $page = 'admin.reports.order_details';
        $title = 'Order History';
        $js = [''];
        $css = 'order_details';

        return view("layouts.admin.layout", compact(
            'title',
            'page',
            'js',
            'order',
            'css'
        ));
    }

    public function user_subscriptions_report(UserSubscriptionReportDataTable $DataTable)
    {
        $title = 'User Subscription Report';
        $page = 'admin.reports.user_subscription_report';
        $js = ['reports'];
        $css = 'reports';
        return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js', 'css'));

    }

    public function exportSubscriptionPdf(Request $request)
    {
        $query = User_subscriptions::with(['user', 'subscription'])
            ->select('user_subscriptions.*');

        if ($request->filled('from_date')) {
            $query->whereDate('start_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('start_date', '<=', $request->to_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $subscriptions = $query->orderBy('start_date', 'desc')->get();

        $pdf = Pdf::loadView('admin.exports.subscription_report_pdf', compact('subscriptions'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('SubscriptionReport_' . date('YmdHis') . '.pdf');
    }

    public function most_sold_product_report(MostSoldProductReportDataTable $DataTable)
    {


        $title = 'Most Sold Product Report';
        $page = 'admin.reports.most_sold_product_report';
        $js = ['reports'];
        $css = 'reports';
        return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js', 'css'));
    }

    public function exportMostSoldPdf(Request $request)
    {
        $subQuery = DB::table('batch_files')
            ->select([
                'batch_files.*',
                DB::raw('COUNT(order_details.id) as total_orders'),
                DB::raw('SUM(orders.total_amount) as total_revenue'),
            ])
            ->join('order_details', 'order_details.product_id', '=', 'batch_files.id')
            ->join('orders', 'orders.id', '=', 'order_details.order_id')
            ->groupBy('batch_files.id');

        if (request()->filled('from_date')) {
            $subQuery->whereDate('orders.created_at', '>=', request('from_date'));
        }

        if (request()->filled('to_date')) {
            $subQuery->whereDate('orders.created_at', '<=', request('to_date'));
        }

        //  Wrap in outer query so total_orders/total_revenue become regular columns
        $products = BatchFile::from(DB::raw("({$subQuery->toSql()}) as batch_files"))
            ->mergeBindings($subQuery)
            ->select('batch_files.*')
            ->with('category')
            ->get();

        $pdf = Pdf::loadView('admin.exports.most_sold_report_pdf', compact('products'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('MostSoldProductReport_' . date('YmdHis') . '.pdf');
    }

    public function most_viewed_product_report(MostViewedProductsReportDataTable $DataTable)
    {
        $title = 'Most Viewed Product Report';
        $page = 'admin.reports.most_viewed_product_report';
        $js = ['reports'];
        $css = 'reports';
        return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js', 'css'));
    }

    public function exportMostViewedPdf(Request $request)
    {
        $query = BatchFile::with('category')
            ->where('views', '>', 0)
            ->orderByDesc('views');

        if (request()->filled('from_date')) {
            $query->whereDate('created_at', '>=', request('from_date'));
        }

        if (request()->filled('to_date')) {
            $query->whereDate('created_at', '<=', request('to_date'));
        }

        $products = $query->get();

        $pdf = Pdf::loadView('admin.exports.most_viewed_report_pdf', compact('products'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('MostViewedProductReport_' . date('YmdHis') . '.pdf');
    }

    public function live_cart_report(LiveCartReportDataTable $DataTable)
    {
        $title = 'Live Cart Product Report';
        $page = 'admin.reports.live_cart_reports';
        $js = ['reports'];
        $css = 'reports';
        return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js', 'css'));
    }

    public function exportLiveCartPdf(Request $request)
    {
        $query = Cart::with(['product', 'user'])
            ->select('carts.*');

        if (request()->filled('from_date')) {
            $query->whereDate('carts.created_at', '>=', request('from_date'));
        }

        if (request()->filled('to_date')) {
            $query->whereDate('carts.created_at', '<=', request('to_date'));
        }
        $query->orderBy('carts.created_at', 'desc');
        $carts = $query->get();

        $pdf = Pdf::loadView('admin.exports.live_cart_report_pdf', compact('carts'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('LiveCartReport_' . date('YmdHis') . '.pdf');
    }
    public function user_wise_order_report(UserWiseOrderReportDataTable $DataTable)
    {
        $title = 'User Wise Order Report';
        $page = 'admin.reports.user_wise_order_reports';
        $js = ['reports'];
        $css = 'reports';
        return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js', 'css'));
    }

    public function exportUserWiseOrderPdf(Request $request)
    {
        $subQuery = DB::table('users')
            ->select([
                'users.*',
                DB::raw('COUNT(orders.id) as total_orders'),
                DB::raw('SUM(orders.total_amount) as total_amount'),
                DB::raw('SUM(CASE WHEN orders.order_status = "completed" THEN 1 ELSE 0 END) as completed_orders'),
                DB::raw('SUM(CASE WHEN orders.order_status = "pending" THEN 1 ELSE 0 END) as pending_orders'),
                DB::raw('SUM(CASE WHEN orders.order_status = "cancelled" THEN 1 ELSE 0 END) as cancelled_orders'),
                DB::raw('MAX(orders.created_at) as last_order_date'),
            ])
            ->join('orders', 'orders.user_id', '=', 'users.id')
            ->groupBy('users.id');

        //  Date filter
        if (request()->filled('from_date')) {
            $subQuery->whereDate('orders.created_at', '>=', request('from_date'));
        }

        if (request()->filled('to_date')) {
            $subQuery->whereDate('orders.created_at', '<=', request('to_date'));
        }

        //  Wrap as subquery for searchable aggregated columns
        $orders = User::from(DB::raw("({$subQuery->toSql()}) as users"))
            ->mergeBindings($subQuery)
            ->select('users.*')
            ->orderBy('users.id','desc')
            ->get();

        $pdf = Pdf::loadView('admin.exports.user_wise_order_report_pdf', compact('orders'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('UserWiseOrderReport_' . date('YmdHis') . '.pdf');
    }
}

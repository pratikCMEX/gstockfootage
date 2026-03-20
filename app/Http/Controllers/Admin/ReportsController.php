<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\LiveCartReportDataTable;
use App\DataTables\MostSoldProductReportDataTable;
use App\DataTables\MostViewedProductsReportDataTable;
use App\DataTables\OrderHistoryDataTable;
use App\DataTables\UserSubscriptionReportDataTable;
use App\DataTables\UserWiseOrderReportDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

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

    public function most_sold_product_report(MostSoldProductReportDataTable $DataTable)
    {
        $title = 'Most Sold Product Report';
        $page = 'admin.reports.most_sold_product_report';
        $js = ['reports'];
        $css = 'reports';
        return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js', 'css'));
    }

    public function most_viewed_product_report(MostViewedProductsReportDataTable $DataTable){
         $title = 'Most Viewed Product Report';
        $page = 'admin.reports.most_viewed_product_report';
        $js = ['reports'];
        $css = 'reports';
        return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js', 'css'));
    }

    public function live_cart_report(LiveCartReportDataTable $DataTable){
         $title = 'Live Cart Product Report';
        $page = 'admin.reports.live_cart_reports';
        $js = ['reports'];
        $css = 'reports';
        return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js', 'css'));
    }
    public function user_wise_order_report(UserWiseOrderReportDataTable $DataTable){
         $title = 'User Wise Order Report';
        $page = 'admin.reports.user_wise_order_reports';
        $js = ['reports'];
        $css = 'reports';
        return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js', 'css'));
    }
}

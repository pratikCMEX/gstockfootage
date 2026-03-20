<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\OrderHistoryDataTable;
use App\DataTables\UserSubscriptionReportDataTable;
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
}

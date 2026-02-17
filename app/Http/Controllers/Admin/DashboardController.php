<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class DashboardController extends Controller
{
    public function index()
    {

        $title = 'Dashboard';
        $page = 'admin.dashboard';

        $totalCategory = Category::count();
        $totalVideo = Product::where('type', '0')->count();
        $totalImage = Product::where('type', '1')->count();
        $totalUser = User::count();

        $options = [
            'chart_title' => 'Image by months',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Image',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'pie',
            'chart_height' => '400px',

        ];
        $chart = new LaravelChart($options);

        return view("layouts.admin.layout", compact(
            'title',
            'page',
            'totalCategory',
            'totalVideo',
            'totalImage',
            'totalUser',
            'chart'
        ));
    }
}

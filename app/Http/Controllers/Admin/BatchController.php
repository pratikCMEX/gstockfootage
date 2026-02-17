<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    public function index()
    {

        $title = 'Batches';
        $page = 'admin.batchs_img.add';
        $js = [];


        return view('layouts.admin.layout', compact('title', 'page', 'js'));
    }
}

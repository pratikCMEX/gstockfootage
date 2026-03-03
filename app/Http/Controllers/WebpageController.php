<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebpageController extends Controller
{
    public function term()
    {
        $title = 'Home';
        $page = 'front.term';
        $js = ['term'];

        return view("layouts.front.layout", compact('title', 'page', 'js'));
    }
}

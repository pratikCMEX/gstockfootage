<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $title = 'Blog';
        $page = 'front.blog.listing';
        $js = ['home'];

        return view("layouts.front.layout", compact('title', 'page', 'js'));
    }

    public function blog_detail()
    {
        $title = 'Blog';
        $page = 'front.blog.blog_detail';
        $js = ['home'];

        return view("layouts.front.layout", compact('title', 'page', 'js'));
    }
}

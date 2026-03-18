<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $title = 'Blog';
        $page = 'front.blog.listing';
        $js = ['home'];
        $blogs=Blog::orderBy('id','desc')->get();
       
        return view("layouts.front.layout", compact('title', 'page', 'js', 'blogs'));
    }

    public function blog_detail()
    {
        $title = 'Blog';
        $page = 'front.blog.blog_detail';
        $js = ['home'];

        $blog_detail=Blog::find(decrypt(request()->id));

        return view("layouts.front.layout", compact('title', 'page', 'js', 'blog_detail'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // dd(1);
        $title = 'Home';
        $page = 'front.home';
        $js = ['home'];
        $categoryList = Category::get();
        $ImageList = Image::get();
        return view('welcome', compact('title', 'categoryList', 'ImageList', 'js'));
    }
}

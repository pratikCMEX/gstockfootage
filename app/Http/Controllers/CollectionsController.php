<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionsController extends Controller
{
    public function index()
    {
        $title = 'Collection';
        $page = 'front.collection';
        $js = ['home'];
        $CollectionList = Collection::get();
        return view("layouts.front.layout", compact('title', 'page', 'CollectionList', 'js'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function addUpdate()
    {
        $title = 'Banner';
        $page = 'admin.banner.addUpdate';
        $js = ['banner'];
        $banner = Banner::where('status', '1')->latest()->first();

        return view('layouts.admin.layout', compact('title', 'page', 'js', 'banner'));
    }
    public function store(Request $request)
    {

        // dd($request);
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp',
        ]);

        $imageName = time() . '.' . $request->image->extension();

        $request->image->move(public_path('uploads/banners'), $imageName);

        Banner::create([
            'title' => $request->title,
            'image' => $imageName,
        ]);

        return redirect()->back()->with('msg_success', 'Banner uploaded successfully');
    }
}

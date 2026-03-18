<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AboutUsController extends Controller
{
    public function index()
    {

        $title = 'About Us';
        $page = 'admin.about_us.add';
        $about_us = AboutUs::first();
        $js = ['about_us'];

        return view("layouts.admin.layout", compact(
            'title',
            'page',
            'about_us',
            'js',

        ));
    }

    public function store(Request $request)
    {
        $id = $request->id;
        
        // Validation rules - image required only for new entries
        $rules = [
            'title' => 'required|max:255',
            'heading' => 'required|max:255',
            'description' => 'required|min:10',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120'
        ];

        $request->validate($rules);

        $data = $request->except(['image', '_token', '_method']);

        if ($id) {
            // Update existing record
            $aboutUs = AboutUs::findOrFail($id);
            
            // Handle image upload for update
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($aboutUs->image && file_exists(public_path('uploads/images/about_us/' . $aboutUs->image))) {
                    unlink(public_path('uploads/images/about_us/' . $aboutUs->image));
                }

                $image = $request->file('image');
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                
                // Create directory if it doesn't exist
                $uploadPath = public_path('uploads/images/about_us');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                // Move image to the folder
                $image->move($uploadPath, $imageName);
                $data['image'] = $imageName;
            }

            $aboutUs->update($data);
            return redirect()->route('admin.about_us')->with('success', 'About Us updated successfully!');
            
        } else {
            // Create new record
            // Handle image upload for create
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                
                // Create directory if it doesn't exist
                $uploadPath = public_path('uploads/images/about_us');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                // Move image to the folder
                $image->move($uploadPath, $imageName);
                $data['image'] = $imageName;
            }

            AboutUs::create($data);
            return redirect()->route('admin.about_us')->with('success', 'About Us created successfully!');
        }
    }
}

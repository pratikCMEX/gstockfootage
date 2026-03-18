<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Social_links;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SocialLinksController extends Controller
{
    public function index()
    {
        $title = 'Social Links';
        $page = 'admin.social_link.add';
        $social_links = Social_links::first();
        $js = ['social_links'];

        return view("layouts.admin.layout", compact(
            'title',
            'page',
            'social_links',
            'js'
        ));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'instagram_link' => 'nullable|url',
                'facebook_link' => 'nullable|url',
                'twitter_link' => 'nullable|url',
                'linkedin_link' => 'nullable|url',
                'youtube_link' => 'nullable|url'
            ]);

            DB::beginTransaction();

            $data = $request->only([
                'instagram_link',
                'facebook_link',
                'twitter_link',
                'linkedin_link',
                'youtube_link'
            ]);

            if ($request->id) {
                // Update existing record
                $id = decrypt($request->id);
                $socialLinks = Social_links::findOrFail($id);
                $socialLinks->update($data);
                $message = 'Social links updated successfully!';
            } else {
                // Create new record
                Social_links::create($data);
                $message = 'Social links created successfully!';
            }

            DB::commit();
            return redirect()->route('admin.social_links')->with('msg_success', $message);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.social_links')->with('msg_error', 'Error: ' . $e->getMessage());
        }
    }
}

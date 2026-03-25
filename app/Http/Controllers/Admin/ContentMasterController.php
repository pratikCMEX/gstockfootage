<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentMaster;
use Illuminate\Http\Request;

class ContentMasterController extends Controller
{
    public function index()
    {

        $title = 'Content Master';
        $page = 'admin.content_master.add';
        $content_master = ContentMaster::first();
       
        $js = ['content_master'];

        return view("layouts.admin.layout", compact(
            'title',
            'page',
            'content_master',
            'js',

        ));
    }

    public function store(Request $request)
    {
        $id = $request->id;

        $sections = [];

        // Get old data if update
        $oldSections = [];
        if ($id) {
            $oldData = ContentMaster::find($id);
            $oldSections = $oldData->content ?? [];
        }

        if ($request->has('sections')) {
            foreach ($request->sections as $key => $section) {

                // Default: keep old image if exists
                $imageName = $oldSections[$key]['image'] ?? null;

                // If new image uploaded → replace
                if ($request->hasFile("sections.$key.image")) {
                    $image = $request->file("sections.$key.image");
                    $imageName = time() . '_' . $key . '.' . $image->getClientOriginalExtension();
                    // $image->move(public_path('uploads/sections'), $imageName);
                    $uploadPath = public_path('uploads/images/content_master');

                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }

                    $image->move($uploadPath, $imageName);
                }

                $sections[] = [
                    'title' => $section['title'] ?? '',
                    'sub_title' => $section['sub_title'] ?? '',
                    'image'     => $imageName,
                    // 'svg' =>  $section['svg'] ?? ''
                ];
            }
        }

        $data = [
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'content' => $sections
        ];

        if ($id) {
            //  UPDATE
            ContentMaster::where('id', $id)->update($data);
        } else {
            //  CREATE
            ContentMaster::create($data);
        }

        return back()->with('msg_success', 'Content Updated successfully');
    }
}

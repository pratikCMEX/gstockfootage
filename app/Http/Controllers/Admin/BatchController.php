<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BatchController extends Controller
{
    public function index()
    {

        $title = 'Batches';
        $page = 'admin.batchs_img.add';
        $js = ['batch'];


        return view('layouts.admin.layout', compact('title', 'page', 'js'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'submission_type' => 'required|string|max:100',
            'batch_name'           => 'required|string|max:255',
            'brief_code'      => 'nullable|string|max:255',
        ]);

        try {

            DB::beginTransaction();
            $batchCode = '#' . mt_rand(10000000, 99999999);
            while (Batch::where('batch_code', $batchCode)->exists()) {
                $batchCode = '#' . mt_rand(10000000, 99999999);
            }

            $batch = Batch::create([
                'batch_code'     => $batchCode,
                'title'          => $request->batch_name,
                'submission_type' => $request->submission_type,
                'brief_code'     => $request->brief_code,
                'status'         => 'draft',
                'total_files'    => 0,
            ]);

            DB::commit();
            return redirect()->route('admin.batch')->with('msg_success', 'Batch Created Successfully !');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.batch')->with('msg_error', 'Batch Not Created Successfully !');
        }
    }
    public function add_new_img()
    {
        $title = 'Batches';
        $page = 'admin.batchs_img.add_new_img';
        $js = ['batch'];

        return view('layouts.admin.layout', compact('title', 'page', 'js'));
    }
}

<?php

namespace App\Http\Controllers\admin;

use App\DataTables\LicenseDataTable;
use App\Http\Controllers\Controller;
use App\Models\License_master;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    public function index(LicenseDataTable $DataTable)
    {
        $title = 'License';
        $page = 'admin.license.list';
        $js = ['category'];
        return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js'));
    }

    public function add_license()
    {
        $title = 'Add License';
        $page = 'admin.license.add';
        $js = ['category'];

        return view("layouts.admin.layout", compact(
            'title',
            'page',
            'js'
        ));
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:100',
                'title' => 'required|string|max:100',
                'price' => 'required',
                'description' => 'required|string',

            ]);

            License_master::create([
                'name' => $request->name,
                'title' => $request->title,
                'price' => $request->price,
                'description' => $request->description,
               
            ]);

            return redirect()->route('admin.license')->with('msg_success', 'License Add successfully !');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('admin.add_license')->with('msg_error', 'License not added' . $e->getMessage());
        }
    }
}

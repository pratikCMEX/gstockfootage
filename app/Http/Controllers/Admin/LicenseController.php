<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\LicenseDataTable;
use App\Http\Controllers\Controller;
use App\Models\License_master;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    public function index(LicenseDataTable $DataTable)
    {
        $title = 'License';
        $page = 'admin.license.list';
        $js = ['license'];
        return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js'));
    }

    public function add_license()
    {
        $title = 'Add License';
        $page = 'admin.license.add';
        $js = ['license'];

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
                'quality' => 'required',
                'description' => 'required|string',

            ]);

            License_master::create([
                'name' => $request->name,
                'title' => $request->title,
                'price' => $request->price,
                'quality' => $request->quality,
                'description' => $request->description,

            ]);

            return redirect()->route('admin.license')->with('msg_success', 'License Add successfully !');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('admin.add_license')->with('msg_error', 'License not added' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $license_id = decrypt($id);

        $title = 'Edit License';
        $page = 'admin.license.edit';
        $js = ['license'];

        $licenseId = $id;
        $getLicenseDetail = License_master::where('id', $license_id)->first();

        return view('layouts.admin.layout', compact('title', 'page', 'js', 'getLicenseDetail', 'licenseId'));
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:100',
                'title' => 'required|string|max:100',
                'price' => 'required',
                'quality' => 'required',
                'description' => 'required|string',

            ]);

            $license_id = decrypt($request->license_id);
            $getData = License_master::where('id', $license_id)->first();

            $getData->name = $request->name;
            $getData->title = $request->title;
            $getData->price = $request->price;
            $getData->quality = $request->quality;
            $getData->description = $request->description;
            $getData->save();

            return redirect()->route('admin.license')->with('msg_success', 'License Updated successfully !');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('admin.license_edit', $license_id)->with('msg_error', 'License not updated' . $e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {

            $id = decrypt($request->id);
            $license = License_master::findOrFail($id);


            $license->delete();
            return response()->json([
                'success' => true,
                'message' => 'License deleted successfully.'
            ]);

        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting License.'
            ]);
        }
    }
 public function deleteMultiple(Request $request)
    {
        try {
            DB::beginTransaction();
            $ids = $request->ids;
            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No IDs provided.'
                ]);
            }
            $users = License_master::whereIn('id', $ids)->get();

            if ($users->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No license found.'
                ]);
            }
            License_master::whereIn('id', $ids)->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Licenses deleted successfully.'
            ]);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error deleting Licenses.'
            ]);
        }
    }
    public function checkLicenseIsExist(Request $request)
    {
        try {

            $license = License_master::where(['name' => $request->name])->get();

            if (count($license) > 0) {
                if (isset($request->id) && !empty($request->id)) {
                    if ($license[0]->id == decrypt($request->id)) {
                        $return = true;
                        echo json_encode($return);
                        exit;
                    }
                }
                $return = false;
            } else {
                $return = true;
            }
            echo json_encode($return);
            exit;
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }

    public function change_most_popular(Request $request)
    {
        try {
            $id = decrypt($request->id);
            $status = $request->status;

            $license = License_master::find($id);
            $license->most_popular = $status;

            $license->save();
            return response()->json(['success' => true]);

        } catch (QueryException $e) {

            return response()->json(['success' => false]);
        }
    }

    
}

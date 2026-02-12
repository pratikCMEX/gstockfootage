<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CollectionDataTable;
use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Image;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

class CollectionController extends Controller
{
    public function index(CollectionDataTable $DataTable)
    {
        $title = 'Collection';
        $page = 'admin.collection.list';
        $js = ['collection'];
        return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js'));
    }

    public function addCollection()
    {
        $title = 'Add Collection';
        $page = 'admin.collection.add';
        $js = ['collection'];

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
                'name' => 'required|string|max:255',
                'image' => 'nullable|file|mimes:jpg,jpeg,png,webp'
            ]);
            DB::beginTransaction();
            $imageName = null;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/images/collection'), $imageName);
            }
            Collection::create([
                'name' => $request->name,
                'image' => $imageName,
            ]);
            DB::commit();
            return redirect()->route('admin.collection')->with('msg_success', 'Collection Add successfully !');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('admin.collection_add')->with('msg_error', 'Collection not added' . $e->getMessage());
        }
    }
    public function edit(string $id)
    {
        $collection_id = decrypt($id);

        $title = 'Edit Collection';
        $page = 'admin.collection.edit';
        $js = ['collection'];

        $catId = $id;
        $getCollectionDetail = collection::where('id', $collection_id)->first();

        return view('layouts.admin.layout', compact('title', 'page', 'js', 'getCollectionDetail', 'catId'));
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);
            DB::beginTransaction();
            $collection_id = decrypt($request->collection_id);
            $getData = Collection::where('id', $collection_id)->first();

            if ($request->hasFile('image')) {
                $oldPath = public_path('uploads/images/collection/' . $getData->image);
                if (!empty($getData->image) && file_exists($oldPath)) {
                    @unlink($oldPath);
                }
                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/images/collection'), $imageName);
                $getData->image = $imageName;
            }
            $getData->name = $request->name;
            $getData->save();
            DB::commit();
            return redirect()->route('admin.collection')->with('msg_success', 'Collection Updated successfully !');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('admin.collection_edit', $collection_id)->with('msg_error', 'Collection not updated' . $e->getMessage());
        }
    }
    public function delete(Request $request)
    {
        try {
            DB::beginTransaction();
            $id = decrypt($request->id);
            $collection = Collection::findOrFail($id);
            $videos = Video::where('collection_id', $id)->get();
            $images = Image::where('collection_id', $id)->get();
            if ($videos->isEmpty() && $images->isEmpty()) {
                $imagePath = public_path('uploads/images/collection/' . $collection->collection_image);

                if (!empty($collection->collection_image) && file_exists($imagePath)) {
                    @unlink($imagePath);
                }

                $collection->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Collection deleted successfully'
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'This Collection has videos or images or sub category available'
                ]);
            }
           
        } catch (QueryException $e) {
            DB::rollBack();
             return response()->json([
                'success' => false,
                'message' => 'Error deleting Collection.'
            ]);
        }
    }

    public function checkCollectionIsExist(Request $request)
    {
        try {
            $collection = Collection::where(['name' => $request->name])->get();
            if (count($collection) > 0) {
                if (isset($request->id) && !empty($request->id)) {
                    if ($collection[0]->id == decrypt($request->id)) {
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
            $category = Collection::whereIn('id', $ids)->get();
            if ($category->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No collection found.'
                ]);
            }

            $videos = Video::whereIn('collection_id', $ids)->get();
            $images = Image::whereIn('collection_id', $ids)->get();
            if ($videos->isEmpty() && $images->isEmpty()) {
                Collection::whereIn('id', $ids)->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Collections deleted successfully.'
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Some collection has videos or images available'
                ]);
            }
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error deleting Collection.'
            ]);
        }
    }
}

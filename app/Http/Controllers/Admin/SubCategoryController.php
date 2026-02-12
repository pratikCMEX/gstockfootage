<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SubCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image;
use App\Models\SubCategory;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class SubCategoryController extends Controller
{

    public function index(SubCategoryDataTable $DataTable)
    {
        $title = 'Sub Category';
        $page = 'admin.sub_category.list';
        $js = ['sub_category'];
        return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js'));
    }
    public function addSubCategory(Request $request)
    {
        $title = 'Add SubCategory';
        $page = 'admin.sub_category.add';
        $js = ['sub_category'];
        $category = Category::all();

        return view("layouts.admin.layout", compact(
            'title',
            'page',
            'js',
            'category'
        ));
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'category' => 'required',
                'image' => 'nullable|file|mimes:jpg,jpeg,png,webp'
            ]);
            DB::beginTransaction();
            $imageName = null;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/images/sub_category'), $imageName);
            }

            SubCategory::create([
                'category_id' => $request->category,
                'name' => $request->name,
                'image' => $imageName,
            ]);
            DB::commit();
            return redirect()->route('admin.sub_category')->with('msg_success', 'SubCategory Add successfully !');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('admin.sub_category_add')->with('msg_error', 'Category not added' . $e->getMessage());
        }
    }
    public function edit(string $id)
    {
        $subcategory_id = decrypt($id);

        $title = 'Edit SubCategory';
        $page = 'admin.sub_category.edit';
        $js = ['sub_category'];
        $category = Category::all();

        $catId = $id;
        $getSubCategoryDetail = SubCategory::with('category')->where('id', $subcategory_id)->first();

        return view('layouts.admin.layout', compact('title', 'page', 'js', 'category', 'getSubCategoryDetail', 'catId'));
    }
    public function update(Request $request)
    {

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'category' => 'required',
            ]);
            DB::beginTransaction();
            $sub_category_id = decrypt($request->subcategory_id);
            $getData = SubCategory::where('id', $sub_category_id)->first();
            if ($request->hasFile('image')) {

                $oldPath = public_path('uploads/images/subcategory/' . $getData->image);

                if (!empty($getData->image) && file_exists($oldPath)) {
                    @unlink($oldPath);
                }

                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();

                $image->move(public_path('uploads/images/sub_category'), $imageName);

                $getData->image = $imageName;
            }
            $getData->category_id = $request->category;
            $getData->name = $request->name;
            // $getData->image = $request->sub_category_name;
            $getData->save();
            DB::commit();
            return redirect()->route('admin.sub_category')->with('msg_success', 'Sub Category Updated successfully !');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('admin.sub_category_edit', $sub_category_id)->with('msg_error', 'Sub Category not updated' . $e->getMessage());
        }
    }
    public function delete(Request $request)
    {
        try {
            DB::beginTransaction();
            $id = decrypt($request->id);
            $subcategory = SubCategory::findOrFail($id);

            $videos = Video::where('subcategory_id', $id)->get();
            $images = Image::where('subcategory_id', $id)->get();
            if ($videos->isEmpty() && $images->isEmpty()) {
                $imagePath = public_path('uploads/images/category/' . $subcategory->image);

                if (!empty($subcategory->image) && file_exists($imagePath)) {
                    @unlink($imagePath);
                }

                $subcategory->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Subcategory deleted successfully'
                ]);

            } else {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'This Subcategory has videos or images available'
                ]);

            }

        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error deleting Subcategory.'
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
            $category = SubCategory::whereIn('id', $ids)->get();
            if ($category->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No SubCategory found.'
                ]);
            }

            $videos = Video::whereIn('subcategory_id', $ids)->get();
            $images = Image::whereIn('subcategory_id', $ids)->get();
            if ($videos->isEmpty() && $images->isEmpty()) {
                SubCategory::whereIn('id', $ids)->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'SubCategory deleted successfully.'
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Some SubCategory has videos or images available'
                ]);
            }
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error deleting SubCategory.'
            ]);
        }
    }
    public function checkSubCategoryIsExist(Request $request)
    {
        try {
            $sub_category = SubCategory::where(['name' => $request->name])->get();
            if (count($sub_category) > 0) {
                if (isset($request->id) && !empty($request->id)) {
                    if ($sub_category[0]->id == decrypt($request->id)) {
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
}

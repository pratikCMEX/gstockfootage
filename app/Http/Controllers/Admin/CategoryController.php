<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\CategoryDataTable;
use App\Models\Category;
use App\Models\Image;
use App\Models\SubCategory;
use App\Models\Video;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class   CategoryController extends Controller
{
    public function index(CategoryDataTable $DataTable)
    {
        $title = 'Category';
        $page = 'admin.category.list';
        $js = ['category'];
        return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js'));
    }

    public function addCategory()
    {
        $title = 'Add Category';
        $page = 'admin.category.add';
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
                'category_name' => 'required|string|max:255',
                'image' => 'nullable|file|mimes:jpg,jpeg,png,webp'
            ]);
            DB::beginTransaction();
            $imageName = null;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($request->category_name) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/images/category'), $imageName);
            }
            Category::create([
                'category_name' => $request->category_name,
                'category_image' => $imageName,
            ]);
            DB::commit();
            return redirect()->route('admin.category')->with('msg_success', 'Category Add successfully !');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('admin.category_add')->with('msg_error', 'Category not added' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $category_id =  decrypt($id);

        $title = 'Edit Category';
        $page = 'admin.category.edit';
        $js = ['category'];

        $catId = $id;
        $getCategoryDetail = Category::where('id', $category_id)->first();

        return view('layouts.admin.layout', compact('title', 'page', 'js', 'getCategoryDetail', 'catId'));
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'category_name' => 'required|string|max:255',
            ]);
            DB::beginTransaction();
            $category_id = decrypt($request->category_id);
            $getData = Category::where('id', $category_id)->first();
            // dd(1);

            if ($request->hasFile('image')) {
                // dd(1);
                $oldPath = public_path('uploads/images/category/' . $getData->category_image);

                if (!empty($getData->category_image) && file_exists($oldPath)) {
                    @unlink($oldPath);
                }

                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();

                $image->move(public_path('uploads/images/category'), $imageName);

                $getData->category_image = $imageName;
            }
            $getData->category_name = $request->category_name;
            $getData->save();
            DB::commit();
            return redirect()->route('admin.category')->with('msg_success', 'Category Updated successfully !');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('admin.category_edit', $category_id)->with('msg_error', 'Category not updated' . $e->getMessage());
        }
    }

    public function delete(string $id)
    {
        try {
            DB::beginTransaction();
            $id = decrypt($id);
            $category = Category::findOrFail($id);
            $videos = Video::where('category_id', $id)->get();
            $images = Image::where('category_id', $id)->get();
            if ($videos->isEmpty() && $images->isEmpty()) {
                $imagePath = public_path('uploads/images/category/' . $category->category_image);

                if (!empty($category->category_image) && file_exists($imagePath)) {
                    @unlink($imagePath);
                }

                $category->delete();
                DB::commit();
                return redirect()->route('admin.category')
                    ->with('msg_success', 'Category deleted successfully');
            } else {
                DB::rollBack();
                return redirect()->route('admin.category')
                    ->with('msg_error', 'This category has videos or images available');
            }
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('admin.category')
                ->with('msg_error', 'Category not deleted');
        }
    }

    public function checkCategoryIsExist(Request $request)
    {
        try {
            $category = Category::where(['category_name' => $request->category_name])->get();
            if (count($category) > 0) {
                if (isset($request->id) && !empty($request->id)) {
                    if ($category[0]->id == decrypt($request->id)) {
                        $return =  true;
                        echo json_encode($return);
                        exit;
                    }
                }
                $return =  false;
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

    public function toggleDisplay(Request $request)
    {
        try {
            $category = Category::findOrFail($request->id);
            if ($category->is_display == "1") {
                $category->is_display = "0";
            } else {
                $category->is_display = "1";
            }
            $category->save();

            return response()->json([
                'success' => true,
                'status' => $category->is_display,
                'message' => 'Display status updated successfully.'
            ]);
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
            $category = Category::whereIn('id', $ids)->get();
            if ($category->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No category found.'
                ]);
            }

            $videos = Video::whereIn('category_id', $ids)->get();
            $images = Image::whereIn('category_id', $ids)->get();
            if ($videos->isEmpty() && $images->isEmpty()) {
                Category::whereIn('id', $ids)->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'category deleted successfully.'
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Some category has videos or images available'
                ]);
            }
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error deleting category.'
            ]);
        }
    }

    public function getSubCategories($category_id)
    {
        $subcategories = SubCategory::where('category_id', $category_id)->get();
        return response()->json($subcategories);
    }
}

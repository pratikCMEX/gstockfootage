<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BlogDataTable;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Str;

class BlogsController extends Controller
{
    public function index(BlogDataTable $DataTable)
    {
        $title = 'Blog';
        $page = 'admin.blog.list';
        $js = ['blog'];
        return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js'));
    }
    public function add()
    {
        $title = 'Add Blog';
        $page = 'admin.blog.add';
        $js = ['blog'];

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
                'title' => 'required|string|max:255',
                'author_name' => 'string|max:255',
                'author_tag' => 'nullable|string|max:100',
                'publish_date' => 'required|date',
                'image' => 'required|file|mimes:jpg,jpeg,png,gif,webp|max:5120',
                'description' => 'required|min:10'
            ]);

            DB::beginTransaction();
            $imageName = null;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();

                $uploadPath = public_path('uploads/images/blogs');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $image->move($uploadPath, $imageName);
            }

            Blog::create([
                'title' => $request->title,
                'author_name' => $request->author_name,
                'author_tag' => $request->author_tag,
                'publish_date' => $request->publish_date,
                'description' => $request->description,
                'image' => $imageName,
            ]);

            DB::commit();
            return redirect()->route('admin.blog')->with('msg_success', 'Blog added successfully!');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('admin.blog_add')->with('msg_error', 'Blog not added: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $blog = Blog::findOrFail(decrypt($id));

            $title = 'Edit Blog';
            $page = 'admin.blog.edit';
            $js = ['blog'];

            return view("layouts.admin.layout", compact(
                'title',
                'page',
                'js',
                'blog'
            ));
        } catch (\Exception $e) {
            return redirect()->route('admin.blog')->with('msg_error', 'Blog not found: ' . $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
                'title' => 'required|string|max:255',
                'author_name' => 'string|max:255',
                'author_tag' => 'nullable|string|max:100',
                'publish_date' => 'required|date',
                'image' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp|max:5120',
                'description' => 'required|min:10'
            ]);

            $id = decrypt($request->id);
            $blog = Blog::findOrFail($id);

            DB::beginTransaction();
            $imageName = $blog->image; // Keep old image by default

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($blog->image && file_exists(public_path('uploads/images/blogs/' . $blog->image))) {
                    unlink(public_path('uploads/images/blogs/' . $blog->image));
                }

                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();

                $uploadPath = public_path('uploads/images/blogs');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $image->move($uploadPath, $imageName);
            }

            $blog->update([
                'title' => $request->title,
                'author_name' => $request->author_name,
                'author_tag' => $request->author_tag,
                'publish_date' => $request->publish_date,
                'description' => $request->description,
                'image' => $imageName,
            ]);

            DB::commit();
            return redirect()->route('admin.blog')->with('msg_success', 'Blog updated successfully!');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('msg_error', 'Blog not updated: ' . $e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {
            DB::beginTransaction();
            $id = decrypt($request->id);
            $blog = Blog::findOrFail($id);


            $imagePath = public_path('uploads/images/blog/' . $blog->image);

            if (!empty($blog->image) && file_exists($imagePath)) {
                @unlink($imagePath);
            }

            $blog->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Blog deleted successfully'
            ]);


        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error deleting Blog.'
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
            $blog = Blog::whereIn('id', $ids)->get();
            if ($blog->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No blog found.'
                ]);
            }

            Blog::whereIn('id', $ids)->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Blogs deleted successfully.'
            ]);

        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error deleting Blogs.'
            ]);
        }
    }

}

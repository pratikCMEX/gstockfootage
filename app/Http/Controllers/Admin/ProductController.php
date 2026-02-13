<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProductDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Jobs\ProcessUploadedVideo; // <-- Import the new job
use App\Models\Category;
use App\Models\Collection;
use App\Models\SubCategory;
use Illuminate\Database\QueryException;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    public function index(ProductDataTable $DataTable)
    {
        $title = 'Products';
        $page = 'admin.product.list';
        $js = ['products'];
        return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js'));
    }

    public function add(Request $request)
    {
        $title = 'Add Product';
        $page = 'admin.product.add';
        $js = ['products'];
        $category = Category::all();
        $subcategory = SubCategory::all();
        $collections = Collection::all();

        return view("layouts.admin.layout", compact(
            'title',
            'page',
            'js',
            'category',
            'subcategory',
            'collections'
        ));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'type' => 'required|in:0,1',
                'category' => 'required|exists:categories,id',
                'subcategory' => 'nullable|exists:sub_categories,id',
                'collection' => 'nullable|exists:collections,id',
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',

                // conditional validation
                // 'file' => 'required_if:type,1|mimes:mp4,mov,avi,wmv',
                // 'image' => 'required_if:type,0|image'
            ]);

            $product = new Product();
            $product->type = $request->type;
            $product->category_id = $request->category;
            $product->subcategory_id = $request->subcategory;
            $product->collection_id = $request->collection;
            $product->name = $request->name;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->tags = $request->tags;

            $tempOriginalPath = null;

            if ($request->type == "0") {
                $this->handleImageUpload($request, $product);
            } else {

                $this->handleProductVideoUpload($product, $request, $tempOriginalPath);
            }

            $product->save();
            DB::commit();

            // 🎬 Dispatch job ONLY for video products
            if ($request->type == "1" && $tempOriginalPath) {
                ProcessUploadedVideo::dispatch($product, $tempOriginalPath);
            }

            return redirect()->route('admin.product')
                ->with('msg_success', 'Product uploaded successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('msg_error', $e->getMessage());
        }
    }


    private function handleImageUpload($request, $product)
    {
        // dd(1);
        $request->validate(['file' => 'required|image']);

        $file = $request->file('file');
        $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        $highDir = public_path('uploads/images/high/');
        $lowDir  = public_path('uploads/images/low/');

        foreach ([$highDir, $lowDir] as $dir) {
            if (!file_exists($dir)) mkdir($dir, 0755, true);
        }

        // 🗑 delete old if exists (this makes it work for UPDATE)
        @unlink(public_path('uploads/' . $product->high_path));
        @unlink(public_path('uploads/' . $product->low_path));

        $manager = new ImageManager(new Driver());
        $img = $manager->read($file->getRealPath());

        $width = $img->width();
        $height = $img->height();
        $size = $file->getSize();

        // high image
        $img->save($highDir . $imageName, 90);

        // low image + watermark
        $low = $manager->read($file->getRealPath());
        $watermarkPath = public_path('watermark.png');

        if (file_exists($watermarkPath)) {
            $wm = $manager->read($watermarkPath);
            $wm->scale(width: $low->width() * 0.1);
            $low->place($wm, 'bottom-right', 10, 10);
        }

        $low->scale(width: 800)->save($lowDir . 'low_' . $imageName, 60);

        $product->high_path = $imageName;
        $product->low_path = 'low_' . $imageName;
        $product->width = $width;
        $product->height = $height;
        $product->file_size = $size;

        // dd(2);  
    }
    private function handleProductVideoUpload(Product $product, Request $request, &$tempOriginalPath = null)
    {
        // If no video uploaded (update case), do nothing
        if (!$request->hasFile('file')) {
            return false;
        }

        $baseDir = public_path('uploads/videos/');
        $highDir = $baseDir . 'high/';
        $lowDir  = $baseDir . 'low/';
        $thumbDir = $baseDir . 'thumbnails/';

        foreach ([$highDir, $lowDir, $thumbDir] as $dir) {
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
        }

        /** 🗑 Delete old files (update case) */
        if ($product->exists) {
            if ($product->high_path && file_exists($highDir . $product->high_path)) {
                @unlink($highDir . $product->high_path);
            }
            if ($product->low_path && file_exists($lowDir . $product->low_path)) {
                @unlink($lowDir . $product->low_path);
            }
            if ($product->thumbnail_path && file_exists($thumbDir . $product->thumbnail_path)) {
                @unlink($thumbDir . $product->thumbnail_path);
            }
        }

        /** 📤 Upload new video */
        $file = $request->file('file');
        $originalFilename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($highDir, $originalFilename);

        $tempOriginalPath = $highDir . $originalFilename;

        /** 💾 Save filename in model */
        $product->high_path = $originalFilename;
        $product->low_path = null;
        $product->thumbnail_path = null;

        return true; // video uploaded
    }



    public function edit(string $id)
    {
        $productId = decrypt($id);

        $title = 'Edit Product';
        $page = 'admin.product.edit';
        $js = ['products'];

        $product = Product::findOrFail($productId);
        $categories = Category::all();
        $collections = Collection::all();

        $subcategories = SubCategory::where(
            'category_id',
            $product->category_id
        )->get();

        return view('layouts.admin.layout', compact(
            'title',
            'page',
            'js',
            'product',
            'categories',
            'collections',
            'subcategories',
            'id'
        ));
    }
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $product = Product::findOrFail(decrypt($id));

            $request->validate([
                'type' => 'required|in:0,1',
                'category' => 'required|exists:categories,id',
                'subcategory' => 'nullable|exists:sub_categories,id',
                'collection' => 'nullable|exists:collections,id',
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                // 'file' => 'nullable|mimes:mp4,mov,avi,wmv',
                // 'image' => 'nullable|image'
            ]);

            // $product->update([
            $product->type = $request->type;
            $product->category_id = $request->category;
            $product->subcategory_id = $request->subcategory;
            $product->collection_id = $request->collection;
            $product->name = $request->name;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->tags = $request->tags;
            // ]);

            $tempOriginalPath = null;

            if ($request->type == "0") {
                $this->handleImageUpload($request, $product);
            } else {
                $uploaded = $this->handleProductVideoUpload($product, $request, $tempOriginalPath);

                if ($uploaded) {
                    ProcessUploadedVideo::dispatch($product, $tempOriginalPath);
                }
            }

            $product->save();
            DB::commit();

            return redirect()->route('admin.product')
                ->with('msg_success', 'Product updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('msg_error', $e->getMessage());
        }
    }
}

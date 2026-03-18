<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProductDataTable;
use App\DataTables\ProductPriorityDataTable;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessBatchVideo;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Jobs\ProcessUploadedVideo; // <-- Import the new job
use App\Models\Batch;
use App\Models\BatchFile;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\Collection;
use App\Models\SubCategory;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class ProductController extends Controller
{
    public function index(ProductDataTable $DataTable)
    {
        $title = 'Products';
        $page = 'admin.product.list';
        $js = ['products'];
        $category = Category::all();
        $subcategory = SubCategory::all();
        $collections = Collection::all();
        return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js', 'category', 'subcategory', 'collections'));
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
                'type' => 'required|in:image,video',
                'category' => 'required|exists:categories,id',
                'subcategory' => 'nullable|exists:sub_categories,id',
                'collection' => 'nullable|exists:collections,id',
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',

                // conditional validation
                // 'file' => 'required_if:type,1|mimes:mp4,mov,avi,wmv',
                // 'image' => 'required_if:type,0|image'
            ]);

            $product = new BatchFile();
            $product->type = $request->type;
            $product->file_code = Str::random(9);
            $product->category_id = $request->category;
            $product->subcategory_id = $request->subcategory;
            $product->collection_id = $request->collection;
            $product->title = $request->name;
            $product->is_edited = '1';
            $product->price = $request->price;
            $product->description = $request->description;
            $product->keywords = $request->tags;

            $tempOriginalPath = null;
            if ($request->type == "image") {
                // dd(1);
                $this->handleImageUpload($request, $product);
            } else {
                $this->handleProductVideoUpload($product, $request, $tempOriginalPath);
            }

            $product->save();
            DB::commit();
            if ($request->type == "video") {
                // ProcessUploadedVideo::dispatch($product, $tempOriginalPath);
                ProcessBatchVideo::dispatch($product->id)->onQueue('videos');
            }
            return redirect()->route('admin.product')->with('msg_success', 'Product uploaded successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('msg_error', $e->getMessage());
        }
    }


    private function handleImageUpload($request, $product)
    {
        $request->validate(['file' => 'required|image']);

        $file      = $request->file('file');
        $imageName = time() . '_' . uniqid() . '.webp';
        $manager   = new ImageManager(new Driver());

        $img    = $manager->read($file->getRealPath());
        $width  = $img->width();
        $height = $img->height();
        $size   = $file->getSize();

        $watermarkPath = storage_path('app/watermark.png');

        // ── WATERMARK HELPER ──────────────────────────────────────────────────────
        $makeWatermark = function (int $baseWidth) use ($manager, $watermarkPath): ?\Intervention\Image\Interfaces\ImageInterface {
            if (!file_exists($watermarkPath)) return null;
            $wm = $manager->read($watermarkPath);
            $wm->scale(width: (int) ($baseWidth * 0.20));
            return $wm;
        };

        $placeWatermark = function ($image, $wm) use ($width, $height): void {
            if (!$wm) return;
            $posX = (int) (($image->width()  / 2) - ($wm->width()  / 2) + ($image->width()  * 0.08));
            $posY = (int) (($image->height() / 2) - ($wm->height() / 2));
            $image->place($wm, 'top-left', $posX, $posY);
        };

        /*
    |--------------------------------------------------------------------------
    | HIGH — 100% quality, original size, with watermark
    |--------------------------------------------------------------------------
    */
        $highImg = $manager->read($file->getRealPath());
        // $placeWatermark($highImg, $makeWatermark($width));
        Storage::disk('s3')->put(
            "batch/images/high/$imageName",
            $highImg->encode(new WebpEncoder(quality: 100))->toString(),
            ['visibility' => 'public']
        );

        /*
    |--------------------------------------------------------------------------
    | MID — 80% quality, original size, with watermark
    |--------------------------------------------------------------------------
    */
        $midImg = $manager->read($file->getRealPath());
        $placeWatermark($midImg, $makeWatermark($width));
        Storage::disk('s3')->put(
            "batch/images/mid/mid_$imageName",
            $midImg->encode(new WebpEncoder(quality: 80))->toString(),
            ['visibility' => 'public']
        );

        /*
    |--------------------------------------------------------------------------
    | LOW — 60% quality, 800px wide, with watermark
    |--------------------------------------------------------------------------
    */
        $lowImg = $manager->read($file->getRealPath());
        $lowImg->scale(width: 800);
        $placeWatermark($lowImg, $makeWatermark($lowImg->width()));
        Storage::disk('s3')->put(
            "batch/images/low/low_$imageName",
            $lowImg->encode(new WebpEncoder(quality: 60))->toString(),
            ['visibility' => 'public']
        );

        /*
    |--------------------------------------------------------------------------
    | SAVE DB
    |--------------------------------------------------------------------------
    */
        $product->original_name = $file->getClientOriginalName();
        $product->file_name     = $imageName;
        $product->file_path     = "batch/images/high/$imageName";
        $product->mid_path      = "batch/images/mid/mid_$imageName";
        $product->low_path      = "batch/images/low/low_$imageName";
        $product->width         = $width;
        $product->height        = $height;
        $product->file_size     = $size;

        unset($img, $highImg, $midImg, $lowImg);
        gc_collect_cycles();
    }
    // private function handleProductVideoUpload(BatchFile $product, Request $request, &$tempOriginalPath = null)
    // {
    //     if (!$request->hasFile('file')) {
    //         return false;
    //     }
    //     $baseDir = public_path('uploads/videos/');
    //     $highDir = $baseDir . 'high/';
    //     $lowDir = $baseDir . 'low/';
    //     $thumbDir = $baseDir . 'thumbnails/';

    //     foreach ([$highDir, $lowDir, $thumbDir] as $dir) {
    //         if (!file_exists($dir)) {
    //             mkdir($dir, 0755, true);
    //         }
    //     }
    //     /** 🗑 Delete old files (update case) */
    //     if ($product->exists) {
    //         if ($product->high_path && file_exists($highDir . $product->high_path)) {
    //             @unlink($highDir . $product->high_path);
    //         }
    //         if ($product->low_path && file_exists($lowDir . $product->low_path)) {
    //             @unlink($lowDir . $product->low_path);
    //         }
    //         if ($product->thumbnail_path && file_exists($thumbDir . $product->thumbnail_path)) {
    //             @unlink($thumbDir . $product->thumbnail_path);
    //         }
    //     }
    //     /** 📤 Upload new video */
    //     $file = $request->file('file');
    //     $originalFilename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    //     $file->move($highDir, $originalFilename);
    //     $tempOriginalPath = $highDir . $originalFilename;

    //     /** 💾 Save filename in model */

    //     $product->original_name = $originalFilename;
    //     $product->file_name = $originalFilename;
    //     $product->file_path = $originalFilename;
    //     // $product->high_path = $originalFilename;
    //     $product->low_path = null;
    //     $product->thumbnail_path = null;

    //     return true; // video uploaded
    // }

    private function handleProductVideoUpload(BatchFile $product, Request $request, &$tempOriginalPath = null)
    {
        if (!$request->hasFile('file')) {
            return false;
        }

        $file = $request->file('file');

        $originalFilename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        /*
        |--------------------------------------------------------------------------
        | Upload ORIGINAL video to S3
        |--------------------------------------------------------------------------
        */

        $path = Storage::disk('s3')->putFileAs(
            'batch/videos/high',
            $file,
            $originalFilename,
            ['visibility' => 'public']
        );

        /*
        |--------------------------------------------------------------------------
        | Save temp path for queue processing
        |--------------------------------------------------------------------------
        */

        $tempOriginalPath = $file->getRealPath();

        /*
        |--------------------------------------------------------------------------
        | Save DB
        |--------------------------------------------------------------------------
        */

        $product->original_name = $file->getClientOriginalName();
        $product->file_name = $originalFilename;
        $product->file_path = $path; // high video path
        $product->low_path = null;
        $product->thumbnail_path = null;

        return true;
    }

    public function edit(string $id)
    {
        $productId = decrypt($id);
        $title = 'Edit Product';
        $page = 'admin.product.edit';
        $js = ['products'];

        $product = BatchFile::findOrFail($productId);
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
            $product = BatchFile::findOrFail(decrypt($id));
            $request->validate([
                'type' => 'required|in:image,video',
                'category' => 'required|exists:categories,id',
                'subcategory' => 'nullable|exists:sub_categories,id',
                'collection' => 'nullable|exists:collections,id',
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                // 'file' => 'nullable|mimes:mp4,mov,avi,wmv',
                // 'image' => 'nullable|image'
            ]);

            $product->type = $request->type;
            $product->category_id = $request->category;
            $product->subcategory_id = $request->subcategory;
            $product->collection_id = $request->collection;
            $product->title = $request->name;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->keywords = $request->tags;
            // $product->save();

            $tempOriginalPath = null;

            if ($request->has('file')) {
                if ($request->type == "image") {
                    $this->handleImageUpload($request, $product);
                } else {
                    $uploaded = $this->handleProductVideoUpload($product, $request, $tempOriginalPath);
                    if ($uploaded) {
                        // ProcessBatchVideo::dispatch($product, $tempOriginalPath);
                        ProcessBatchVideo::dispatch($product->id)->onQueue('videos');
                    }
                }
            }
            $product->save();

            DB::commit();

            return redirect()->route('admin.product')->with('msg_success', 'Product updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('msg_error', $e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = decrypt($request->id);
            BatchFile::findOrFail($id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Product not deleted'
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
                    'message' => 'No products selected'
                ]);
            }

            $products = BatchFile::whereIn('id', $ids)->get();

            foreach ($products as $product) {
                $product->delete(); // model event will unlink files
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Products deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    public function priority(ProductPriorityDataTable $DataTable)
    {
        $title = 'Products';
        $page = 'admin.product.priority';
        $js = ['products', 'product_priority'];
        $category = Category::all();
        $subcategory = SubCategory::all();
        $collections = Collection::all();
        // $products = BatchFile::where('is_edited', '1')->whereNull('priority')->orWhere('priority', 0)->get();

        $products = BatchFile::where('is_edited', '1')
            ->where(function ($query) {
                $query->whereNull('priority')
                    ->orWhere('priority', 0);
            })
            ->get();
        $priorityProducts = BatchFile::where('is_edited', '1')->Where('priority', '!=', 0)
            ->orderBy('priority', 'asc')
            ->get();

        return view("layouts.admin.layout", compact(
            'title',
            'page',
            'js',
            'category',
            'subcategory',
            'collections',
            'products',
            'priorityProducts'
        ));
        // return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js', 'category', 'subcategory', 'collections'));
    }
    public function updatePriority(Request $request)
    {
        $imageOrder = $request->imageOrder ?? [];
        $videoOrder = $request->videoOrder ?? [];

        // Reset all first
        BatchFile::whereIn('type', ['image', 'video'])->update([
            'priority' => 0
        ]);

        // Image priority
        foreach ($imageOrder as $index => $id) {
            BatchFile::where('id', $id)->update([
                'priority' => $index + 1
            ]);
        }

        // Video priority
        foreach ($videoOrder as $index => $id) {
            BatchFile::where('id', $id)->update([
                'priority' => $index + 1
            ]);
        }

        return response()->json([
            'status' => true
        ]);
    }
    public function updatePriority_old(Request $request)
    {
        $order = $request->order ?? [];

        // Reset priority for products removed from priority list
        BatchFile::whereNotIn('id', $order)->update([
            'priority' => 0
        ]);

        // Update priority for selected products
        foreach ($order as $index => $id) {

            BatchFile::where('id', $id)->update([
                'priority' => $index + 1
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Priority updated successfully'
        ]);
    }
}

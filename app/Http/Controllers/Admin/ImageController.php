<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\ImagesDataTable;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Image;
use App\Models\SubCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageController extends Controller
{
    public function index(ImagesDataTable $DataTable)
    {
        $title = 'Images';
        $page = 'admin.images.list';
        $js = ['images'];
        return $DataTable->render('layouts.admin.layout', compact('title', 'page', 'js'));
    }
    public function addimage(Request $request)
    {
        $title = 'Add Image';
        $page = 'admin.images.add';
        $js = ['images'];
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
        // dd($request);
        try {
            $request->validate([
                'category' => 'required|exists:categories,id',
                'image_name' => 'required|string|max:255',
                'image_price' => 'required|numeric',
                'image_description' => 'nullable|string',
                'image' => 'nullable|file|',
            ]);
            DB::beginTransaction();

            $image = new Image();
            $image->category_id = $request->category;
            $image->collection_id = $request->collection;
            $image->subcategory_id = $request->subcategory;
            $image->image_name = $request->image_name;
            $image->image_price = $request->image_price;
            $image->image_description = $request->image_description;
            $image->tags = $request->input('tags');

            $uploadedImage = $request->file('image');
            $imageName = time() . '.' . $uploadedImage->getClientOriginalExtension();

            $baseDir = public_path('uploads/images/');
            $highDir = $baseDir . 'high/';
            $lowDir  = $baseDir . 'low/';

            foreach ([$highDir, $lowDir] as $dir) {
                if (!file_exists($dir)) {
                    mkdir($dir, 0755, true);
                }
            }

            $manager = new ImageManager(new Driver());

            // --- HIGH QUALITY SAVE ---
            $highPath = $highDir . $imageName;
            $manager->read($uploadedImage->getRealPath())
                ->save($highPath, 90); // 90% quality

            // --- LOW QUALITY SAVE (with watermark + resize) ---
            $lowPath = $lowDir . 'low_' . $imageName;
            $watermarkPath = public_path('watermark.png');

            $lowQualityImage = $manager->read($uploadedImage->getRealPath());
            if (file_exists($watermarkPath)) {
                $watermark = $manager->read($watermarkPath);
                $watermark->scale(width: $lowQualityImage->width() * 0.1);
                $lowQualityImage->place($watermark, 'bottom-right', 10, 10);
            }

            $lowQualityImage->scale(width: 800)->save($lowPath, 60);

            $image->high_path = $imageName;
            $image->low_path  =  'low_' . $imageName;

            $image->save();

            DB::commit();
            return redirect()
                ->route('admin.image')
                ->with('msg_success', 'Image uploaded successfully!');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('msg_error', 'Error: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $image_id =  decrypt($id);

        $title = 'Edit Image';
        $page = 'admin.images.edit';
        $js = ['images'];
        $category = Category::all();
        $collections = Collection::all();

        $imageId = $id;
        $getImageDetail = Image::where('id', $image_id)->first();
        $subcategories = SubCategory::where(
            'category_id',
            $getImageDetail->category_id
        )->get();

        // dd($getImageDetail);
        $category = Category::all();
        return view('layouts.admin.layout', compact('title', 'page', 'js', 'getImageDetail', 'category', 'collections', 'subcategories', 'imageId'));
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category' => 'required|exists:categories,id',
            'image_name' => 'required|string|max:255',
            'image_price' => 'required|numeric',
            'image_description' => 'nullable|string',
        ]);
        try {
            DB::beginTransaction();
            $id = decrypt($id);
            $image = Image::findOrFail($id);

            $image->category_id = $request->category;
            $image->image_name = $request->image_name;
            $image->image_price = $request->image_price;
            $image->image_description = $request->image_description;
            $image->tags = $request->input('tags');

            if ($request->hasFile('image')) {
                $uploadedImage = $request->file('image');
                $imageName = time() . '.' . $uploadedImage->getClientOriginalExtension();

                $baseDir = public_path('uploads/images/');
                $highDir = $baseDir . 'high/';
                $lowDir  = $baseDir . 'low/';

                foreach ([$highDir, $lowDir] as $dir) {
                    if (!file_exists($dir)) {
                        mkdir($dir, 0755, true);
                    }
                }

                $manager = new ImageManager(new Driver());

                // --- Delete old images if they exist ---
                $oldHigh = $highDir . $image->high_path;
                $oldLow  = $lowDir . 'low_' . $image->low_path;

                if (file_exists($oldHigh)) unlink($oldHigh);
                if (file_exists($oldLow)) unlink($oldLow);

                $highPath = $highDir . $imageName;
                $manager->read($uploadedImage->getRealPath())
                    ->save($highPath, 90);

                $lowPath = $lowDir . 'low_' . $imageName;
                $watermarkPath = public_path('watermark.png');

                $lowQualityImage = $manager->read($uploadedImage->getRealPath());
                if (file_exists($watermarkPath)) {
                    $watermark = $manager->read($watermarkPath);
                    $watermark->scale(width: $lowQualityImage->width() * 0.1);
                    $lowQualityImage->place($watermark, 'bottom-right', 10, 10);
                }

                $lowQualityImage->scale(width: 800)->save($lowPath, 60);

                $image->high_path = $imageName;
                $image->low_path  = $imageName;
            }

            $image->save();

            DB::commit();

            return redirect()
                ->route('admin.image')
                ->with('msg_success', 'Image updated successfully!');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('msg_error', 'Error: ' . $e->getMessage());
        }
    }
    public function delete(string $id)
    {
        try {
            DB::beginTransaction();
            $id = decrypt($id);
            $image = Image::findOrFail($id);

            $baseDir = public_path('uploads/images/');
            $highDir = $baseDir . 'high/';
            $lowDir  = $baseDir . 'low/';

            $highPath = $highDir . $image->high_path;
            $lowPath  = $lowDir . 'low_' . $image->low_path;

            if (file_exists($highPath)) {
                unlink($highPath);
            }
            if (file_exists($lowPath)) {
                unlink($lowPath);
            }
            $image->delete();
            DB::commit();

            return redirect()
                ->route('admin.image')
                ->with('msg_success', 'Image deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('msg_error', 'Error deleting image: ' . $e->getMessage());
        }
    }
    public function toggleDisplay(Request $request)
    {
        try {
            $images = Image::findOrFail($request->id);
            if ($images->is_display == "1") {
                $images->is_display = "0";
            } else {
                $images->is_display = "1";
            }
            $images->save();

            return response()->json([
                'success' => true,
                'status' => $images->is_display,
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
            $images = Image::whereIn('id', $ids)->get();

            if ($images->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No images found.'
                ]);
            }

            $baseDir = public_path('uploads/images/');
            $highDir = $baseDir . 'high/';
            $lowDir  = $baseDir . 'low/';
            foreach ($images as $img) {

                $highPath = $highDir . $img->high_path;
                $lowPath  = $lowDir . $img->low_path;

                if (file_exists($highPath)) unlink($highPath);
                if (file_exists($lowPath)) unlink($lowPath);
            }
            Image::whereIn('id', $ids)->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Images deleted successfully.'
            ]);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error deleting images.'
            ]);
        }
    }
}

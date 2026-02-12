<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class HomeController extends Controller
{
    public function index()
    {
        // dd(1);
        $title = 'Home';
        $page = 'front.home';
        $js = ['home'];
        $categoryList = Category::get();
        $ImageList = Image::get();
        return view('welcome', compact('title', 'categoryList', 'ImageList', 'js'));
    }
    public function imageDetail(Request $request)
    {
        try {
            $image = Image::with(['category', 'subcategory', 'collection'])
                ->findOrFail(38);

            $data = [
                'id'          => $image->id,
                'title'       => $image->image_name,
                'description' => $image->image_description ?? 'No description available',
                'image_url'   => asset('uploads/images/high/' . $image->high_path),
                'location'    => $image->subcategory->name ?? '',
                'resolution'  => $image->width . ' x ' . $image->height,
                'file_size'   => formatFileSize((int)$image->file_size),
                'tags'        => explode(',', $image->tags ?? ''),
                'price'       => $image->image_price,
                'category'    => $image->category->category_name ?? '',
                'collection'  => $image->collection->name ?? '',
            ];
            return view('image.show', compact('data'));
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('msg_error', 'Error: ' . $e->getMessage());
        }
    }

    public function getImageList(Request $request)
    {
        try {
            $images = Image::with(['category', 'subcategory', 'collection'])
                ->latest()
                ->get();

            $data = $images->map(function ($image) {
                return [
                    'id'          => $image->id,
                    'title'       => $image->image_name,
                    'description' => $image->image_description ?? 'No description available',
                    'image_url'   => asset('uploads/images/high/' . $image->high_path),
                    'location'    => optional($image->subcategory)->name,
                    'resolution'  => $image->width . ' x ' . $image->height,
                    'file_size'   => formatFileSize((int)$image->file_size),
                    'tags'        => $image->tags ? explode(',', $image->tags) : [],
                    'price'       => $image->image_price,
                    'category'    => optional($image->category)->category_name,
                    'collection'  => optional($image->collection)->name,
                ];
            });
            // dd($data);
            return view('image.show', compact('data'));
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('msg_error', 'Error: ' . $e->getMessage());
        }
    }
}

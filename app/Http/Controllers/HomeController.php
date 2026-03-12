<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\BatchFile;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Image;
use App\Models\Order;
use App\Models\Product;
use App\Models\Testimonials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function order_mail(Request $request)
    {
        $order = Order::with(['order_details.product', 'user'])->find(1);
        // dd($order);
        return view('emails.order_details', compact('order'));
    }
    public function index()
    {
        $title = 'Home';
        $page = 'front.home';
        $js = ['home', 'favorites'];
        $userId = Auth::id();

        // $js = [''];
        $categoryList = Category::get();
        $ImageList = Image::get();
        $CollectionList = Collection::limit(4)->get();
        // $product = Product::with('category')->limit(4)->get();
        $product = BatchFile::with('category')
            ->withCount([
                'favorites as is_favorite' => function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                }
            ])->where('is_edited', '1')
            ->limit(4)
            ->get();
        // dd($product);
        $testimonials = Testimonials::where('is_active', '1')->get();
        return view("layouts.front.layout", compact('title', 'page', 'categoryList', 'ImageList', 'CollectionList', 'product', 'js', 'testimonials'));
    }
    public function productDetail(string $id)
    {
        $title = 'Product Detail View';
        $page = 'front.product_detail';
        $js = ['favorites'];
        try {
            $id = decrypt($id);
            // $id = 19;
            $product = Product::with(['category', 'subcategory', 'collection'])
                ->findOrFail($id);
            $data = [
                'id' => $product->id,
                'title' => $product->name,
                'description' => $product->description ?? 'No description available',
                'tags' => $product->tags ? explode(',', $product->tags) : [],
                'price' => $product->price,
                'category' => optional($product->category)->category_name,
                'collection' => optional($product->collection)->name,
                'location' => optional($product->subcategory)->sub_category_name,
                'type' => $product->type,
            ];

            if ($product->type == "0") {
                $data['file_url'] = asset('uploads/images/high/' . $product->high_path);
                $data['low_path'] = $product->low_path;
                $data['resolution'] = $product->width . ' x ' . $product->height;
                $data['file_size'] = formatFileSize((int) $product->file_size);
            }

            if ($product->type == "1") {
                $data['file_url'] = asset('uploads/videos/high/' . $product->high_path);
                $data['low_path'] = $product->low_path;
                $data['thumbnail'] = asset('uploads/videos/high/' . $product->thumbnail_path);
                $data['resolution'] = 'HD Video';
                $data['file_size'] = 'Video File';
            }

            // return view('product.show', compact('data'));
            return view("layouts.front.layout", compact('title', 'page', 'data', 'js'));
        } catch (\Exception $e) {
            return back()->with('msg_error', $e->getMessage());
        }
    }

    public function productList()
    {
        try {
            $products = Product::with(['category', 'subcategory', 'collection'])
                ->where('is_display', '1')
                ->latest()
                ->get();

            $data = $products->map(function ($product) {
                $preview = $product->type == "0"
                    ? asset('uploads/images/low/' . $product->low_path)
                    : asset('uploads/videos/thumbnails/' . $product->thumbnail_path);
                $url = $product->type == "0"
                    ? asset('uploads/images/high/' . $product->high_path)
                    : asset('uploads/videos/high/' . $product->high_path);
                return [
                    'id' => $product->id,
                    'title' => $product->name,
                    'preview' => $preview,
                    'url' => $url,
                    'price' => $product->price,
                    'type' => $product->type,
                    'category' => optional($product->category)->category_name,
                    'collection' => optional($product->collection)->name,
                    'sub_category' => optional($product->subcategory)->name,
                    'tags' => $product->tags ? explode(',', $product->tags) : [],
                ];
            });

            dd($data);
            return view('product.list', compact('data'));
        } catch (\Exception $e) {
            return back()->with('msg_error', $e->getMessage());
        }
    }

    public function videos()
    {
        $title = 'Videos';
        $page = 'front.videos';
        $js = ['home'];

        $categories=Category::where('is_display','1')->get();
        $CollectionList = Collection::get();
        // $product = Product::with('category')->where('type', '1')->get();
         
         $allVideos = BatchFile::with(['category'])
        ->where('type', 'video')
        ->where('is_edited', '1')
        ->get();
       
        return view("layouts.front.layout", compact('title', 'page', 'allVideos','categories', 'js'));
    }


    public function allPhotos()
    {
        $title = 'Videos';
        $page = 'front.all_photos';
        $js = ['photos', 'favorites'];

        $categories=Category::where('is_display','1')->get();
        // $photos = Batch::with('batch_files')->where('submission_type', 'image')->get();
        $allPhotos = BatchFile::with(['category'])
        ->where('type', 'image')
        ->where('is_edited', '1')
        ->get();

      

        return view("layouts.front.layout", compact('title', 'page', 'js', 'categories','allPhotos'));
    }
    public function enterprise()
    {
        $title = 'Enterprise';
        $page = 'front.enterprise';
        $js = ['enterprise'];


        return view("layouts.front.layout", compact('title', 'page', 'js'));
    }

    public function about()
    {
        $title = 'About us';
        $page = 'front.about_us';

        return view("layouts.front.layout", compact('title', 'page'));
    }

    public function homeSearch(Request $request)
    {
        $getData = BatchFile::where('keywords', 'like', '%' . $request->search . '%')->where('is_edited', '1')->get();
        return response()->json($getData);
    }
}

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
use Illuminate\Support\Facades\Storage;

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
            $product = BatchFile::with(['category', 'subcategory', 'collection'])
                ->findOrFail($id);
            $data = [
                'id' => $product->id,
                'title' => $product->title,
                'description' => $product->description ?? 'No description available',
                'tags' => $product->keywords ? explode(',', $product->keywords) : [],
                'price' => $product->price,
                'category' => optional($product->category)->category_name,
                'collection' => optional($product->collection)->name,
                'location' => optional($product->subcategory)->sub_category_name,
                'type' => $product->type,
            ];

            if ($product->type == "image") {
                $data['file_url'] = Storage::disk('s3')->url($product->file_path);
                $data['low_path'] = Storage::disk('s3')->url($product->low_path);
                $data['resolution'] = $product->width . ' x ' . $product->height;
                $data['file_size'] = formatFileSize((int) $product->file_size);
            }

            if ($product->type == "video") {
                $data['file_url'] = Storage::disk('s3')->url($product->file_path);
                $data['low_path'] = Storage::disk('s3')->url($product->low_path);
                $data['thumbnail'] = Storage::disk('s3')->url($product->thumbnail);
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

            // dd($data);
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

        $CollectionList = Collection::get();
        $product = Product::with('category')->where('type', '1')->get();
        return view("layouts.front.layout", compact('title', 'page', 'product', 'js'));
    }


    public function allPhotos()
    {
        $title = 'Videos';
        $page = 'front.all_photos';
        $js = ['photos', 'favorites'];

        // $photos = Batch::with('batch_files')->where('submission_type', 'image')->get();
        $photos = Batch::with([
            'batch_files' => function ($query) {
                $query->where('is_edited', 1);
            }
        ])->where('submission_type', 'image')->get();

        $orphans = BatchFile::whereNull('batch_id')
            ->where('type', 'image')
            ->where('is_edited', '1')
            ->get();


        $new = $photos[0]->batch_files->toArray();
        $allBatches = array_merge($new, $orphans->toArray());

        return view("layouts.front.layout", compact('title', 'page', 'js', 'allBatches'));
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
        $keywords = BatchFile::where('is_edited', 1)
            ->pluck('keywords')
            ->toArray();

        $allKeywords = [];

        foreach ($keywords as $keywordString) {

            if ($keywordString) {
                $split = explode(',', $keywordString);

                foreach ($split as $word) {
                    $allKeywords[] = trim($word);
                }
            }
        }

        $allKeywords = array_unique($allKeywords);

        if ($request->search) {
            $allKeywords = array_filter($allKeywords, function ($word) use ($request) {
                return stripos($word, $request->search) !== false;
            });
        }

        // dd($allKeywords);

        return response()->json(array_values($allKeywords));
    }

    public function downloadAllFiles()
    {
        $files = Storage::disk('s3')->allFiles();

        $localPath = storage_path('app/s3-downloads/');

        if (!file_exists($localPath)) {
            mkdir($localPath, 0777, true);
        }

        foreach ($files as $file) {

            $fileContent = Storage::disk('s3')->get($file);

            $savePath = $localPath . $file;

            $dir = dirname($savePath);

            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }

            file_put_contents($savePath, $fileContent);
        }

        return "All files downloaded successfully";
    }
}

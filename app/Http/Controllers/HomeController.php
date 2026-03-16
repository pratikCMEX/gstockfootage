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
            $productDatas = BatchFile::with('category')->where('is_edited', '1')
                ->where('id', '!=', $id) // exclude this product
                ->withExists([
                    'favorites as is_favorite' => function ($query) {
                        $query->where('user_id', auth()->id());
                    }
                ])
                ->limit(6)
                ->get();
            // $id = 19;
            $product = BatchFile::with(['category', 'subcategory', 'collection'])
                ->withExists([
                    'favorites as is_favorite' => function ($query) {
                        $query->where('user_id', auth()->id());
                    }
                ])
                ->findOrFail($id);
            // dd($product);
            $data = [
                'id' => $product->id,
                'title' => $product->title,
                'description' => $product->description ?? 'No description available',
                'tags' => $product->keywords ? explode(',', $product->keywords) : [],
                'price' => $product->price,
                'category' => optional($product->category)->category_name,
                'collection' => optional($product->collection)->name,
                'location' => $product->country ?? 'N/A',
                'type' => $product->type,
                'is_favorite' => $product->is_favorite
            ];

            if ($product->type == "image") {
                $data['file_url'] = Storage::disk('s3')->url($product->file_path);
                $data['low_path'] = Storage::disk('s3')->url($product->low_path);
                $data['resolution'] = $product->width . ' x ' . $product->height;
                $data['file_size'] = formatFileSize((int) $product->file_size);
            }

            if ($product->type == "video") {

                $data['file_url'] = $product->file_path
                    ? Storage::disk('s3')->url($product->file_path)
                    : '';

                $data['low_path'] = $product->low_path
                    ? Storage::disk('s3')->url($product->low_path)
                    : asset('assets/admin/images/demo_thumbnail.png');

                $data['thumbnail'] = $product->thumbnail_path
                    ? Storage::disk('s3')->url($product->thumbnail_path)
                    : asset('assets/admin/images/demo_thumbnail.png');

                $data['resolution'] = 'HD Video';
                $data['file_size'] = 'Video File';
            }

            // dd($data);
            // return view('product.show', compact('data'));
            return view("layouts.front.layout", compact('title', 'page', 'data', 'js', 'productDatas'));
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

    public function videos_old(Request $request)
    {
        $title = 'Videos';
        $page = 'front.videos';
        $js = ['home', 'favorites'];

        $q = $request->get('q', '');

        $collection_id = $request->has('collection_id')
            ? decrypt($request->get('collection_id'))
            : null;

        $category_id = $request->has('category_id')
            ? decrypt($request->get('category_id'))
            : null;

        $categories = Category::where('is_display', '1')->get();
        $CollectionList = Collection::get();

        $query = BatchFile::with(['category'])
            ->where('type', 'video')
            ->where('is_edited', '1')
            ->withExists([
                'favorites as is_favorite' => function ($q) {
                    $q->where('user_id', auth()->id());
                }
            ]);
        if ($q) {
            $query->where('keywords', 'like', '%' . $q . '%');
        }
        if ($collection_id) {
            $query->where('collection_id', $collection_id);
        }

        if ($category_id) {
            $query->where('category_id', $category_id);        // ← new
        }
        $allVideos = $query->get();

        return view("layouts.front.layout", compact('title', 'page', 'allVideos', 'categories', 'js'));
    }

    public function videos(Request $request)
    {
        $title = 'Videos';
        $page = 'front.videos';
        $js = ['home', 'favorites', 'videos'];

        $q              = $request->get('q', '');
        $collection_id  = $request->has('collection_id') ? decrypt($request->get('collection_id')) : null;
        $category_id    = $request->has('category_id')   ? decrypt($request->get('category_id'))   : null;

        // ── New filter params ──────────────────────────────────────────────────────
        $price_min      = $request->get('price_min', 0);
        $price_max      = $request->get('price_max', 500);
        $duration_min   = $request->get('duration_min', 0);
        $duration_max   = $request->get('duration_max', 120);
        $resolutions    = $request->get('resolution', []);      // array: ['hd','fullhd','4k']
        $frame_rates    = $request->get('frame_rate', []);      // array: ['24','30','60','120']
        $orientations   = $request->get('orientation', []);     // array: ['landscape','portrait','square','vertical']
        $license        = $request->get('license', '');         // 'standard'|'premium'|'editorial'
        $camera_moves   = $request->get('camera_movement', []); // array: ['static','pan',…]
        $with_people    = $request->get('with_people', '');     // '1' or ''
        $sort           = $request->get('sort', 'relevant');    // sort order
        // ──────────────────────────────────────────────────────────────────────────

        $categories     = Category::where('is_display', '1')->get();
        $CollectionList = Collection::get();

        $query = BatchFile::with(['category'])
            ->where('type', 'video')
            ->where('is_edited', '1')
            ->withExists([
                'favorites as is_favorite' => function ($q) {
                    $q->where('user_id', auth()->id());
                }
            ]);

        // Keyword search
        if ($q) {
            $query->where('keywords', 'like', '%' . $q . '%');
        }

        // Collection / Category
        if ($collection_id) {
            $query->where('collection_id', $collection_id);
        }
        if ($category_id) {
            $query->where('category_id', $category_id);
        }

        // Price range
        $query->whereBetween('price', [(float)$price_min, (float)$price_max]);

        // Duration range (stored in seconds in DB — adjust column name if different)
        if ((int)$duration_min > 0) {
            $query->where('duration', '>=', (int)$duration_min);
        }
        if ((int)$duration_max < 120) {
            $query->where('duration', '<=', (int)$duration_max);
        }

        // Resolution  — adjust column name to match your DB ('resolution' | 'video_resolution' etc.)
        if (!empty($resolutions)) {
            $map = ['hd' => 'HD', 'fullhd' => 'Full HD', '4k' => '4K'];
            $values = array_map(fn($r) => $map[$r] ?? $r, $resolutions);
            $query->whereIn('resolution', $values);
        }

        // Frame rate  — adjust column name ('frame_rate' | 'fps' etc.)
        if (!empty($frame_rates)) {
            $query->whereIn('frame_rate', array_map('intval', $frame_rates));
        }

        // Orientation — adjust column name ('orientation' etc.)
        if (!empty($orientations)) {
            $query->whereIn('orientation', $orientations);
        }

        // License type — adjust column name ('license_type' etc.)
        if ($license) {
            $query->where('license_type', ucfirst($license));
        }

        // Camera movement — adjust column name ('camera_movement' etc.)
        if (!empty($camera_moves)) {
            $query->where(function ($q) use ($camera_moves) {
                foreach ($camera_moves as $move) {
                    $q->orWhere('camera_movement', 'like', '%' . $move . '%');
                }
            });
        }

        // With people — adjust column name ('has_people' | 'with_people' as boolean/tinyint)
        if ($with_people === '1') {
            $query->where('has_people', 1);
        }

        // Sorting
        switch ($sort) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'popular':
                $query->orderBy('views', 'desc');   // adjust column if different
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'duration_asc':
                $query->orderBy('duration', 'asc');
                break;
            case 'duration_desc':
                $query->orderBy('duration', 'desc');
                break;
            default: // 'relevant' — keep default DB order or add your own relevance logic
                $query->orderBy('id', 'desc');
                break;
        }

        $allVideos = $query->get();

        // AJAX: return only the card partial so JS can swap it without a full reload
        if ($request->ajax()) {
            return response()->json([
                'html'  => view('front.partials.video-cards', compact('allVideos'))->render(),
                'count' => $allVideos->count(),
            ]);
        }

        return view("layouts.front.layout", compact(
            'title',
            'page',
            'allVideos',
            'categories',
            'js',
            'price_min',
            'price_max',
            'duration_min',
            'duration_max',
            'resolutions',
            'frame_rates',
            'orientations',
            'license',
            'camera_moves',
            'with_people',
            'sort',
            'q'
        ));
    }

    public function allPhotos(Request $request)
    {
        $title = 'Photos';
        $page = 'front.all_photos';
        $js = ['home', 'favorites'];

        $q = $request->get('q', '');
        $type = $request->get('type', 'image');
        $collection_id = $request->has('collection_id')
            ? decrypt($request->get('collection_id'))
            : null;

        $category_id = $request->has('category_id')
            ? decrypt($request->get('category_id'))
            : null;

        // $collection_id = decrypt($collection_id);
        // $category_id = decrypt($category_id);

        $categories = Category::where('is_display', '1')->get();

        $query = BatchFile::with(['category'])
            ->where('type', 'image')
            ->where('is_edited', '1')
            ->withExists([
                'favorites as is_favorite' => function ($q) {
                    $q->where('user_id', auth()->id());
                }
            ]);

        if ($q) {
            $query->where('keywords', 'like', '%' . $q . '%');
        }

        if ($collection_id) {
            $query->where('collection_id', $collection_id);
        }

        if ($category_id) {
            $query->where('category_id', $category_id);        // ← new
        }

        $allPhotos = $query->get();

        $selectedCollection = $collection_id ? Collection::find($collection_id) : null;
        $selectedCategory = $category_id ? Category::find($category_id) : null;  // ← new

        return view("layouts.front.layout", compact(
            'title',
            'page',
            'js',
            'categories',
            'allPhotos',
            'selectedCollection',
            'selectedCategory'
        ));
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
        $search = $request->get('search', '');
        $type = $request->get('type', 'all');
        $query = BatchFile::where('is_edited', 1)
            ->where('keywords', 'like', '%' . $search . '%');

        if ($type !== 'all') {
            $query->where('type', $type);
        }

        $keywords = $query->limit(10)->pluck('keywords');

        $allKeywords = [];

        foreach ($keywords as $keywordString) {
            if ($keywordString) {
                foreach (explode(',', $keywordString) as $word) {
                    $trimmed = trim($word);
                    if ($trimmed !== '') {
                        $allKeywords[] = $trimmed;
                    }
                }
            }
        }

        $allKeywords = array_unique($allKeywords);

        // Filter keywords that actually contain the search term
        if ($search) {
            $allKeywords = array_filter($allKeywords, function ($word) use ($search) {
                return stripos($word, $search) !== false;
            });
        }

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

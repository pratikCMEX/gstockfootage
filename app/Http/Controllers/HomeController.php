<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Models\Batch;
use App\Models\BatchFile;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Collection;
use App\Models\ContentMaster;
use App\Models\Image;
use App\Models\Order;
use App\Models\Product;
use App\Models\Testimonials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\Environment\Console;

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
        $categoryList = Category::where('is_display', '1')->get();
        $ImageList = Image::get();
        $CollectionList = Collection::limit(4)->get();
        // $product = Product::with('category')->limit(4)->get();
        $product = BatchFile::with('category')
            ->withCount([
                'favorites as is_favorite' => function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                }
            ])->where('is_edited', '1')
            ->whereHas('category', function ($q) {
                $q->where('is_display', '1');
            })            //  PRIORITY FIRST
            ->orderByRaw("
        CASE 
            WHEN priority IS NULL OR priority = 0 THEN 1
            ELSE 0
        END
    ")
            ->orderBy('priority', 'ASC')

            //  FALLBACK
            ->orderBy('id', 'DESC')

            ->limit(4)
            ->get();

        $content_master = ContentMaster::first();

        $testimonials = Testimonials::where('is_active', '1')->get();
        $blogs = Blog::limit(3)->orderBy('id', 'desc')->get();

        $popularProducts = BatchFile::with('category')
            ->withCount([
                'favorites as is_favorite' => function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                }
            ])
            ->whereHas('category', function ($q) {
                $q->where('is_display', '1');
            })
            ->where('is_edited', '1')
            ->orderBy('views', 'desc')
            ->limit(4)
            ->get();

        $latestProducts = BatchFile::with('category')
            ->withCount([
                'favorites as is_favorite' => function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                }
            ])
            ->whereHas('category', function ($q) {
                $q->where('is_display', '1');
            })
            ->where('is_edited', '1')
            ->orderBy('id', 'desc')
            ->limit(4)
            ->get();

        $trendingTags = BatchFile::with('category')->where('is_edited', '1')
            ->whereNotNull('keywords')
            ->where('keywords', '!=', '')
            ->orderBy('views', 'desc')
            ->whereHas('category', function ($q) {
                $q->where('is_display', '1');
            })
            ->limit(7)
            ->get(['id', 'category_id', 'keywords', 'type'])
            ->map(fn($product) => [
                'product_id' => $product->id,
                'category_id' => $product->category_id,
                'tag' => trim(explode(',', $product->keywords)[0]),
                'type' => strtolower(trim($product->type)) // ✅ normalize
            ])
            ->filter(fn($item) => !empty($item['tag']))
            ->unique('tag')
            ->take(7)
            ->values();


        return view("layouts.front.layout", compact('title', 'page', 'categoryList', 'ImageList', 'CollectionList', 'product', 'js', 'testimonials', 'content_master', 'blogs', 'popularProducts', 'latestProducts', 'trendingTags'));
    }
    public function productDetail(string $id)
    {
        $title = 'Product Detail View';
        $page = 'front.product_detail';
        $js = ['home', 'favorites'];
        try {
            $id = decrypt($id);
            $product = BatchFile::with(['category', 'subcategory', 'collection'])
                ->withExists([
                    'favorites as is_favorite' => function ($query) {
                        $query->where('user_id', auth()->id());
                    }
                ])
                ->findOrFail($id);

            $productDatas = BatchFile::with('category')->where('is_edited', '1')

                ->whereHas('category', function ($q) {
                    $q->where('is_display', '1');
                })
                ->where('id', '!=', $id) // exclude this product
                ->where('type', $product->type) // exclude this product
                ->withExists([
                    'favorites as is_favorite' => function ($query) {
                        $query->where('user_id', auth()->id());
                    }
                ])
                ->limit(6)
                ->get();
            // $id = 19;


            $product->incrementView();
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
                'is_favorite' => $product->is_favorite,
                'downloads' => $product->downloads
            ];

            if ($product->type == "image") {
                $data['file_url'] = $product->file_path ? Storage::disk('s3')->url($product->file_path) : '';
                $data['low_path'] = $product->low_path ? Storage::disk('s3')->url($product->low_path) : '';
                $data['mid_path'] = $product->mid_path ? Storage::disk('s3')->url($product->mid_path) : '';
                $data['resolution'] = $product->height . ' x ' . $product->width;
                $data['file_size'] = formatFileSize((int) $product->file_size);
            }

            if ($product->type == "video") {

                $data['file_url'] = $product->file_path
                    ? Storage::disk('s3')->url($product->file_path)
                    : '';

                $data['low_path'] = $product->low_path
                    ? Storage::disk('s3')->url($product->low_path)
                    : asset('assets/admin/images/demo_thumbnail.png');
                $data['mid_path'] = $product->mid_path
                    ? Storage::disk('s3')->url($product->mid_path)
                    : asset('assets/admin/images/demo_thumbnail.png');

                $data['preview_path'] = $product->preview_path
                    ? Storage::disk('s3')->url($product->preview_path)
                    : asset('assets/admin/images/demo_thumbnail.png');

                $data['thumbnail'] = $product->thumbnail_path
                    ? Storage::disk('s3')->url($product->thumbnail_path)
                    : asset('assets/admin/images/demo_thumbnail.png');

                $data['hls_path'] = $product->hls_path ? Storage::disk('s3')->url($product->hls_path) : '';

                // $data['resolution'] = 'HD Video';
                $data['resolution'] = $product->height . ' x ' . $product->width;

                $data['file_size'] = formatFileSize((int) $product->file_size);
            }

            // dd($data);
            // return view('product.show', compact('data'));
            return view("layouts.front.layout", compact('title', 'page', 'data', 'js', 'productDatas'));
        } catch (\Exception $e) {
            return back()->with('msg_error', $e->getMessage());
        }
    }
    // public function allMedia(Request $request)
    // {
    //     $title = 'All Media';
    //     $page  = 'front.all_media';
    //     $js = ['home', 'favorites'];

    //     // ── Get collection 1 with its media ──
    //     // $collectionId = decrypt($request->collection_id);
    //     $q = $request->get('q', '');
    //     $type = $request->get('type', 'image');
    //     $collectionId = $request->has('collection_id')
    //         ? decrypt($request->get('collection_id'))
    //         : null;



    //     $collection = Collection::where('id', $collectionId)->first();
    //     $media = BatchFile::with('category')
    //         ->whereHas('category', function ($q) {
    //             $q->where('is_display', '1');
    //         })
    //         ->where('collection_id', $collectionId)
    //         ->where('is_edited', '1')
    //         ->withExists([
    //             'favorites as is_favorite' => function ($q) {
    //                 $q->where('user_id', auth()->id());
    //             }
    //         ])
    //         // ->where('status', 'approved')
    //         ->latest()
    //         ->get();

    //     $query = BatchFile::with(['category'])
    //         ->whereHas('category', function ($q) {
    //             $q->where('is_display', '1');
    //         })
    //         ->where('type', 'image')
    //         ->where('is_edited', '1')
    //         ->withExists([
    //             'favorites as is_favorite' => function ($q) {
    //                 $q->where('user_id', auth()->id());
    //             }
    //         ]);


    //     if ($q && !$collectionId) {
    //         $keywords = collect(explode(',', $q))
    //             ->map(fn($k) => trim($k))
    //             ->filter()
    //             ->values();

    //         $query->where(function ($mainQuery) use ($keywords) {

    //             if ($keywords->count() === 1) {

    //                 $keyword = $keywords->first();

    //                 $mainQuery->where(function ($q) use ($keyword) {
    //                     $q->where('keywords', 'like', '%' . $keyword . '%')
    //                         ->orWhere('title', 'like', '%' . $keyword . '%')
    //                         ->orWhereHas('category', function ($q) use ($keyword) {
    //                             $q->where('category_name', 'like', '%' . $keyword . '%');
    //                         })
    //                         ->orWhereHas('collection', function ($q) use ($keyword) {
    //                             $q->where('name', 'like', '%' . $keyword . '%');
    //                         });
    //                 });
    //             } else {

    //                 $mainQuery->where(function ($q) use ($keywords) {

    //                     foreach ($keywords as $keyword) {

    //                         $q->orWhere(function ($sub) use ($keyword) {
    //                             $sub->where('keywords', 'like', '%' . $keyword . '%')
    //                                 ->orWhere('title', 'like', '%' . $keyword . '%')
    //                                 ->orWhereHas('category', function ($q) use ($keyword) {
    //                                     $q->where('category_name', 'like', '%' . $keyword . '%');
    //                                 })
    //                                 ->orWhereHas('collection', function ($q) use ($keyword) {
    //                                     $q->where('name', 'like', '%' . $keyword . '%');
    //                                 });
    //                         });
    //                     }
    //                 });
    //             }
    //         });
    //     }

    //     $photos = $media->where('type', 'image')->values();
    //     $videos = $media->where('type', 'video')->values();

    //     $categories = Category::whereHas('batchfiles', function ($q) use ($collectionId) {
    //         $q->where('collection_id', $collectionId)->where('is_display', '1');
    //     })->get();

    //     return view('layouts.front.layout', compact(
    //         'title',
    //         'page',
    //         'collection',
    //         'media',
    //         'photos',
    //         'videos',
    //         'categories',
    //         'js'
    //     ));
    // }


    public function productList()
    {
        try {
            $products = Product::with(['category', 'subcategory', 'collection'])
                ->where('is_display', '1')
                ->whereHas('category', function ($q) {
                    $q->where('is_display', '1');
                })
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
    public function printStore(Request $request)
    {

        $title = 'Print';
        $page = 'front.print_store';
        $js = ['home'];

        return view("layouts.front.layout", compact('title', 'page', 'js'));
    }
    public function videos(Request $request)
    {

        // dd($request);
        $title = 'Videos';
        $page = 'front.videos';
        $js = ['home', 'favorites', 'videos'];

        // $collection_id = $request->has('collection_id') ? decrypt($request->get('collection_id')) : null;
        $collection_id = [];
        if ($request->has('collection_id')) {

            $raw = $request->get('collection_id');

            // $collection_ids = collect((array) $request->get('collection_id'))
            $collection_id = collect(is_array($raw) ? $raw : [$raw])

                ->map(fn($id) => decrypt($id))
                ->filter()
                ->values()
                ->toArray();

            // single string handled below via $collection_id
        }
        $category_id = [];
        if ($request->has('category_id')) {
            $raw = $request->get('category_id');
            $category_id = collect(is_array($raw) ? $raw : [$raw])
                ->map(fn($id) => decrypt($id))
                ->filter()
                ->values()
                ->toArray();
        }
        $subcategory_ids = [];
        if ($request->has('subcategory_id')) {
            $subcategory_ids = collect((array) $request->get('subcategory_id'))
                ->map(fn($id) => decrypt($id))
                ->filter()
                ->values()
                ->toArray();
        }
        // ── Dynamic max values from DB ────────────────────────────────────────────
        $maxPrice = (int) BatchFile::where('type', 'video')->where('is_edited', '1')->max('price') ?: 500;
        $maxDuration = (int) BatchFile::where('type', 'video')->where('is_edited', '1')->max('duration') ?: 120;
        // ─────────────────────────────────────────────────────────────────────────

        // ── Filter params: only read from request on AJAX, else use defaults ──────
        $q = $request->get('q', '');

        if ($request->ajax()) {
            // dd(1);
            $price_min = $request->get('price_min', 0);
            $price_max = $request->get('price_max', $maxPrice);
            $duration_min = $request->get('duration_min', 0);
            $duration_max = $request->get('duration_max', $maxDuration);
            $resolutions = $request->get('resolution', []);
            $frame_rates = $request->get('frame_rate', []);
            $orientations = $request->get('orientation', []);
            $license = $request->get('license', '');
            $camera_moves = $request->get('camera_movement', []);
            $with_people = $request->get('with_people', '');
            $sort = $request->get('sort', 'relevant');
            $content_filters = $request->get('content_filters', []);
        } else {
            // Only filters reset — NOT q
            $price_min = 0;
            $price_max = $maxPrice;
            $duration_min = 0;
            $duration_max = $maxDuration;
            $resolutions = [];
            $frame_rates = [];
            $orientations = [];
            $license = '';
            $camera_moves = [];
            $with_people = '';
            $sort = 'relevant';
            $content_filters = [];
        }
        // ─────────────────────────────────────────────────────────────────────────

        // $categories = Category::where('is_display', '1')->get();
        $CollectionList = Collection::get();

        $selectedCollection = $collection_id ? Collection::find($collection_id) : null;

        $selectedCategory = $category_id ? Category::find($category_id) : null;  // ← new
        $categories = Category::where('is_display', '1')
            ->with('subcategories') // ← make sure this matches your actual relation name
            ->get();


        $query = BatchFile::with(['category'])
            ->where('type', 'video')
            ->where('is_edited', '1')
            ->whereHas('category', function ($q) {
                $q->where('is_display', '1');
            })
            ->withExists([
                'favorites as is_favorite' => function ($q) {
                    $q->where('user_id', auth()->id());
                }
            ]);

        // Keyword search
        // dd(1);
        if ($q) {

            $keywords = collect(explode(',', $q))
                ->map(fn($k) => trim($k))
                ->filter()
                ->values();

            $query->where(function ($mainQuery) use ($keywords) {

                foreach ($keywords as $keyword) {

                    $mainQuery->orWhere(function ($subQuery) use ($keyword) {

                        $subQuery->where('keywords', 'like', "%{$keyword}%")
                            ->orWhere('title', 'like', "%{$keyword}%")
                            ->orWhereHas('category', function ($q) use ($keyword) {
                                $q->where('category_name', 'like', "%{$keyword}%");
                            })
                            ->orWhereHas('collection', function ($q) use ($keyword) {
                                $q->where('name', 'like', "%{$keyword}%");
                            });
                    });
                }
            });
        }

        // Collection / Category
        if ($collection_id) {
            $query->whereIn('collection_id', $collection_id);
        }

        if ($category_id) {
            // dd(1);
            $query->whereIn('category_id', $category_id);
        }

        if ($subcategory_ids) {
            $query->whereIn('subcategory_id', $subcategory_ids);
        }

        // Price range
        // $query->whereBetween('price', [(float) $price_min, (float) $price_max]);
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }
        // Duration range
        if ((int) $duration_min > 0) {
            $query->where('duration', '>=', (int) $duration_min);
        }
        if ((int) $duration_max < $maxDuration) {
            $query->where('duration', '<=', (int) $duration_max);
        }

        // Resolution
        if (!empty($resolutions)) {
            $map = ['hd' => 'HD', 'fullhd' => 'Full HD', '4k' => '4K'];
            $values = array_map(fn($r) => $map[$r] ?? $r, $resolutions);
            $query->whereIn('resolution', $values);
        }

        // Frame rate
        if (!empty($frame_rates)) {
            $query->whereIn('frame_rate', array_map('intval', $frame_rates));
        }

        // Orientation
        if (!empty($orientations)) {
            $query->whereIn('orientation', $orientations);
        }

        // License type
        if ($license) {
            $query->where('license_type', ucfirst($license));
        }

        // Camera movement
        if (!empty($camera_moves)) {
            $query->where(function ($q) use ($camera_moves) {
                foreach ($camera_moves as $move) {
                    $q->orWhere('camera_movement', 'like', '%' . $move . '%');
                }
            });
        }

        // With people
        if ($with_people === '1') {
            $query->where('has_people', 1);
        }

        // Content filters
        if (!empty($content_filters)) {
            $query->where(function ($q) use ($content_filters) {
                foreach ($content_filters as $filter) {
                    $q->orWhereJsonContains('content_filters', $filter);
                }
            });
        }
        // $query->orderByRaw("
        //         CASE 
        //             WHEN priority IS NULL OR priority = 0 THEN 1
        //             ELSE 0
        //         END
        //     ");

        // $query->orderBy('priority', 'ASC');

        // Sorting
        // dd($sort);
        switch ($sort) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'popular':
                $query->orderBy('views', 'desc');
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
            default: // "relevant"
                $query->orderByRaw("
                    CASE 
                        WHEN priority IS NULL OR priority = 0 THEN 1
                        ELSE 0
                    END
                ");
                $query->orderBy('priority', 'asc');
                $query->orderBy('id', 'desc');
                break;
        }

        // dd($query->toSql());
        $maxPriceI = $query->max('price');
        $maxDurationI = $query->max('duration');
        $allVideos = $query->paginate(9)->withQueryString();


        // $allVideos = $query->get();

        // Tags from all videos (unfiltered)

        $etags = BatchFile::with('category')->where('is_edited', '1')
            ->whereNotNull('keywords')
            ->where('type', 'video')
            ->whereHas('category', function ($q) {
                $q->where('is_display', '1');
            })
            ->where('keywords', '!=', '')
            ->orderBy('views', 'desc')
            ->limit(7)
            ->get(['id', 'category_id', 'keywords', 'type'])
            ->map(fn($product) => [
                'product_id' => $product->id,
                'category_id' => $product->category_id,
                'tag' => trim(explode(',', $product->keywords)[0]),
                'type' => strtolower(trim($product->type)) // ✅ normalize
            ])
            ->filter(fn($item) => !empty($item['tag']))
            ->unique('tag')
            ->take(7)
            ->values();

        // AJAX: return partial HTML + count
        if ($request->ajax()) {
            return response()->json([
                'html' => view('front.partials.video-cards', compact('allVideos'))->render(),
                'count'    => $allVideos->total(),
                'hasMore'  => $allVideos->hasMorePages(),
                'nextPage' => $allVideos->currentPage() + 1,
            ]);
        }

        $trendingTags = BatchFile::with('category')->where('is_edited', '1')
            ->whereNotNull('keywords')

            ->whereHas('category', function ($q) {
                $q->where('is_display', '1');
            })
            ->where('keywords', '!=', '')
            ->orderBy('views', 'desc')
            ->limit(7)
            ->get(['id', 'category_id', 'keywords', 'type'])
            ->map(fn($product) => [
                'product_id' => $product->id,
                'category_id' => $product->category_id,
                'tag' => trim(explode(',', $product->keywords)[0]),
                'type' => strtolower(trim($product->type)) // ✅ normalize
            ])
            ->filter(fn($item) => !empty($item['tag']))
            ->unique('tag')
            ->take(7)
            ->values();

        return view("layouts.front.layout", compact(
            'title',
            'page',
            'js',
            'allVideos',
            'categories',
            'CollectionList',
            'q',
            'price_min',
            'price_max',
            'maxPrice',
            'maxPriceI',
            'duration_min',
            'duration_max',
            'maxDuration',
            'maxDurationI',
            'resolutions',
            'frame_rates',
            'orientations',
            'license',
            'camera_moves',
            'content_filters',
            'with_people',
            'sort',
            'etags',
            'trendingTags',
            'selectedCategory',
            'selectedCollection'
        ));
    }
    public function allPhotos(Request $request)
    {
        $title = 'Photos';
        $page  = 'front.all_photos';
        $js    = ['home', 'favorites', 'images'];

        $q             = $request->get('q', '');
        $collection_id = $request->has('collection_id') ? decrypt($request->get('collection_id')) : null;

        // category_id — single (URL) or array (JS filter)
        $category_id = null;
        if ($request->has('category_id')) {
            $raw = $request->get('category_id');
            $category_id = collect(is_array($raw) ? $raw : [$raw])
                ->map(fn($id) => decrypt($id))
                ->filter()
                ->values()
                ->toArray();
        }

        // subcategory_id[]
        $subcategory_ids = [];
        if ($request->has('subcategory_id')) {
            $subcategory_ids = collect((array) $request->get('subcategory_id'))
                ->map(fn($id) => decrypt($id))
                ->filter()
                ->values()
                ->toArray();
        }
        $collection_ids = [];
        if ($request->has('collection_ids')) {
            // $raw = $request->get('collection_ids');
            // could be single string (URL param) or array (JS checkboxes)
            $collection_ids = collect((array) $request->get('collection_ids'))
                ->map(fn($id) => decrypt($id))
                ->filter()
                ->values()
                ->toArray();

            // single string handled below via $collection_id
        }
        // dd($collection_ids);
        $price_min       = $request->get('price_min', null);
        $price_max       = $request->get('price_max', null);
        $orientation     = $request->get('orientation', []);
        $content_filters = $request->get('content_filters', []);

        $categories = Category::where('is_display', '1')
            ->with('subcategories') // ← make sure this matches your actual relation name
            ->get();

        $collections = Collection::get();

        $query = BatchFile::with(['category'])
            ->where('type', 'image')
            ->whereHas('category', function ($q) {
                $q->where('is_display', '1');
            })
            ->where('is_edited', '1')
            ->withExists([
                'favorites as is_favorite' => function ($q) {
                    $q->where('user_id', auth()->id());
                }
            ]);

        // Search
        if ($q) {
            $keywords = collect(explode(',', $q))
                ->map(fn($k) => trim($k))
                ->filter()
                ->values();

            $query->where(function ($mainQuery) use ($keywords) {
                if ($keywords->count() === 1) {
                    $keyword = $keywords->first();
                    $mainQuery->where(function ($q) use ($keyword) {
                        $q->where('keywords', 'like', '%' . $keyword . '%')
                            ->orWhere('title', 'like', '%' . $keyword . '%')
                            ->orWhereHas('category', function ($q) use ($keyword) {
                                $q->where('category_name', 'like', '%' . $keyword . '%');
                            })
                            ->orWhereHas('collection', function ($q) use ($keyword) {
                                $q->where('name', 'like', '%' . $keyword . '%');
                            });
                    });
                } else {
                    $mainQuery->where(function ($q) use ($keywords) {
                        foreach ($keywords as $keyword) {
                            $q->orWhere(function ($sub) use ($keyword) {
                                $sub->where('keywords', 'like', '%' . $keyword . '%')
                                    ->orWhere('title', 'like', '%' . $keyword . '%')
                                    ->orWhereHas('category', function ($q) use ($keyword) {
                                        $q->where('category_name', 'like', '%' . $keyword . '%');
                                    })
                                    ->orWhereHas('collection', function ($q) use ($keyword) {
                                        $q->where('name', 'like', '%' . $keyword . '%');
                                    });
                            });
                        }
                    });
                }
            });
        }

        if ($collection_id)          $query->where('collection_id', $collection_id);
        if (!empty($category_id))    $query->whereIn('category_id', $category_id);
        if (!empty($subcategory_ids)) $query->whereIn('subcategory_id', $subcategory_ids);
        if (!empty($collection_ids))      $query->whereIn('collection_id', $collection_ids); // ← from checkboxes
        if ($price_min)              $query->where('price', '>=', $price_min);
        if ($price_max)              $query->where('price', '<=', $price_max);
        if (!empty($orientation))    $query->whereIn('orientation', $orientation);
        if (!empty($content_filters)) {
            $query->where(function ($q) use ($content_filters) {
                foreach ($content_filters as $filter) {
                    $q->orWhereJsonContains('content_filters', $filter);
                }
            });
        }

        $query->orderByRaw("CASE WHEN priority IS NULL OR priority = 0 THEN 1 ELSE 0 END");
        $query->orderBy('priority', 'ASC');
        $query->orderBy('id', 'DESC');

        // ── ONE paginate call only ──
        $maxPrice = $query->max('price');

        $allPhotos = $query->paginate(9)->withQueryString();

        $selectedCollection = $collection_id ? Collection::find($collection_id) : null;
        $selectedCategory   = !empty($category_id) ? Category::find($category_id[0]) : null;

        $trendingTags = BatchFile::with('category')
            ->where('is_edited', '1')
            ->whereHas('category', function ($q) {
                $q->where('is_display', '1');
            })
            ->whereNotNull('keywords')
            ->where('keywords', '!=', '')
            ->orderBy('views', 'desc')
            ->limit(7)
            ->get(['id', 'category_id', 'keywords', 'type'])
            ->map(fn($product) => [
                'product_id'  => $product->id,
                'category_id' => $product->category_id,
                'tag'         => trim(explode(',', $product->keywords)[0]),
                'type'        => strtolower(trim($product->type)),
            ])
            ->filter(fn($item) => !empty($item['tag']))
            ->unique('tag')
            ->take(7)
            ->values();

        if ($request->ajax()) {
            return response()->json([
                'html'     => view('front.partials.photo_grid', compact('allPhotos'))->render(),
                'count'    => $allPhotos->total(),
                'hasMore'  => $allPhotos->hasMorePages(),
                'nextPage' => $allPhotos->currentPage() + 1,
            ]);
        }

        return view('layouts.front.layout', compact(
            'title',
            'page',
            'js',
            'categories',
            'collections',
            'allPhotos',
            'maxPrice',
            'selectedCollection',
            'selectedCategory',
            'trendingTags',
            'price_min',
            'price_max',
            'orientation',
            'content_filters'
        ));
    }
    public function allMedia(Request $request)
    {
        $title = 'All Media';
        $page  = 'front.all_media';
        $js    = ['home', 'favorites'];

        $q            = $request->get('q', '');
        $type         = $request->get('type', 'image');
        $collectionId = $request->has('collection_id')
            ? decrypt($request->get('collection_id'))
            : null;

        $category_id = $request->has('category_id')
            ? decrypt($request->get('category_id'))
            : null;

        $collection = $collectionId ? Collection::find($collectionId) : null;

        $categories = Category::where('is_display', '1')
            ->whereHas('batchfiles', function ($q) use ($collectionId) {
                $q->where('is_edited', '1');
                if ($collectionId) {
                    $q->where('collection_id', $collectionId);
                }
            })
            ->get();

        // ── Main query ──
        $query = BatchFile::with(['category'])
            ->whereHas('category', function ($q) {
                $q->where('is_display', '1');
            })
            ->where('is_edited', '1')
            ->withExists([
                'favorites as is_favorite' => function ($q) {
                    $q->where('user_id', auth()->id());
                }
            ]);

        // Filter by collection
        if ($collectionId) {
            $query->where('collection_id', $collectionId);
        }

        // Filter by category
        if ($category_id) {
            $query->where('category_id', $category_id);
        }

        // Filter by type (image/video)
        // if ($type) {
        //     $query->where('type', $type);
        // }

        // Search keywords (only when no collection filter)
        if ($q) {
            $keywords = collect(explode(',', $q))
                ->map(fn($k) => trim($k))
                ->filter()
                ->values();

            $query->where(function ($mainQuery) use ($keywords) {
                if ($keywords->count() === 1) {
                    $keyword = $keywords->first();
                    $mainQuery->where(function ($q) use ($keyword) {
                        $q->where('keywords', 'like', '%' . $keyword . '%')
                            ->orWhere('title', 'like', '%' . $keyword . '%')
                            ->orWhereHas('category', function ($q) use ($keyword) {
                                $q->where('category_name', 'like', '%' . $keyword . '%');
                            })
                            ->orWhereHas('collection', function ($q) use ($keyword) {
                                $q->where('name', 'like', '%' . $keyword . '%');
                            });
                    });
                } else {
                    $mainQuery->where(function ($q) use ($keywords) {
                        foreach ($keywords as $keyword) {
                            $q->orWhere(function ($sub) use ($keyword) {
                                $sub->where('keywords', 'like', '%' . $keyword . '%')
                                    ->orWhere('title', 'like', '%' . $keyword . '%')
                                    ->orWhereHas('category', function ($q) use ($keyword) {
                                        $q->where('category_name', 'like', '%' . $keyword . '%');
                                    })
                                    ->orWhereHas('collection', function ($q) use ($keyword) {
                                        $q->where('name', 'like', '%' . $keyword . '%');
                                    });
                            });
                        }
                    });
                }
            });
        }

        // ── Ordering (same as allPhotos) ──


        $media = $query->get();

        // ── Split into photos & videos ──
        $photos = $media->where('type', 'image')->values();
        $videos = $media->where('type', 'video')->values();

        $selectedCollection = $collection;
        $selectedCategory   = $category_id ? Category::find($category_id) : null;

        // ── Trending tags ──
        $trendingTags = BatchFile::with('category')
            ->where('is_edited', '1')
            ->whereHas('category', function ($q) {
                $q->where('is_display', '1');
            })
            ->whereNotNull('keywords')
            ->where('keywords', '!=', '')
            ->orderBy('views', 'desc')
            ->limit(7)
            ->get(['id', 'category_id', 'keywords', 'type'])
            ->map(fn($product) => [
                'product_id' => $product->id,
                'category_id' => $product->category_id,
                'tag'  => trim(explode(',', $product->keywords)[0]),
                'type' => strtolower(trim($product->type)),
            ])
            ->filter(fn($item) => !empty($item['tag']))
            ->unique('tag')
            ->take(7)
            ->values();

        return view('layouts.front.layout', compact(
            'title',
            'page',
            'js',
            'categories',
            'media',
            'photos',
            'videos',
            'collection',
            'selectedCollection',
            'selectedCategory',
            'trendingTags'
        ));
    }
    public function searchByImage(Request $request)
    {
        // dd($request);
        $request->validate([
            'image' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:5120',
            ],
        ], [
            'image.max' => 'The image must not be greater than 5 MB.',
        ]);

        $image = $request->file('image');
        $base64 = base64_encode(file_get_contents($image->getRealPath()));

        // ── Call Google Vision API ────────────────────────────────────────────────
        $apiKey = config('services.google_vision.key');
        $endpoint = "https://vision.googleapis.com/v1/images:annotate?key={$apiKey}";

        $response = Http::post($endpoint, [
            'requests' => [
                [
                    'image' => ['content' => $base64],
                    'features' => [
                        ['type' => 'LABEL_DETECTION', 'maxResults' => 15],
                        ['type' => 'LANDMARK_DETECTION', 'maxResults' => 5],
                        ['type' => 'OBJECT_LOCALIZATION', 'maxResults' => 10],
                    ],
                ]
            ],
        ]);

        if ($response->failed()) {
            return back()->withErrors(['image' => 'Image analysis failed. Please try again.']);
        }

        $result = $response->json();

        // ── Extract keywords ──────────────────────────────────────────────────────
        $keywords = collect();

        $labels = data_get($result, 'responses.0.labelAnnotations', []);
        $keywords = $keywords->merge(
            collect($labels)->filter(fn($l) => $l['score'] >= 0.70)->pluck('description')
        );

        $landmarks = data_get($result, 'responses.0.landmarkAnnotations', []);
        $keywords = $keywords->merge(collect($landmarks)->pluck('description'));

        $objects = data_get($result, 'responses.0.localizedObjectAnnotations', []);
        $keywords = $keywords->merge(
            collect($objects)->filter(fn($o) => $o['score'] >= 0.70)->pluck('name')
        );

        $keywords = $keywords->unique()->filter()->values();

        if ($keywords->isEmpty()) {
            return back()->withErrors(['image' => 'Could not detect anything from this image. Please try another.']);
        }

        // ── Redirect to photos page with q param ──────────────────────────────────
        return redirect()->route('all_photos', [
            'q' => $keywords->join(', '),
        ]);
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
        $about_us = AboutUs::first();

        $blogs = Blog::limit(4)->orderBy('id', 'desc')->get();

        return view("layouts.front.layout", compact('title', 'page', 'about_us', 'blogs'));
    }

    // public function homeSearch(Request $request)
    // {
    //     $search = $request->get('search', '');
    //     $type = $request->get('type', 'all');
    //     $query = BatchFile::where('is_edited', 1)
    //         ->where('keywords', 'like', '%' . $search . '%');

    //     if ($type !== 'all') {
    //         $query->where('type', $type);
    //     }

    //     $keywords = $query->limit(10)->pluck('keywords');

    //     $allKeywords = [];

    //     foreach ($keywords as $keywordString) {
    //         if ($keywordString) {
    //             foreach (explode(',', $keywordString) as $word) {
    //                 $trimmed = trim($word);
    //                 if ($trimmed !== '') {
    //                     $allKeywords[] = $trimmed;
    //                 }
    //             }
    //         }
    //     }

    //     $allKeywords = array_unique($allKeywords);

    //     // Filter keywords that actually contain the search term
    //     if ($search) {
    //         $allKeywords = array_filter($allKeywords, function ($word) use ($search) {
    //             return stripos($word, $search) !== false;
    //         });
    //     }

    //     return response()->json(array_values($allKeywords));
    // }
    public function homeSearch(Request $request)
    {

        $search = $request->get('search', '');
        $type = $request->get('type', 'all');

        $query = BatchFile::query()
            ->with(['category', 'collection'])
            ->whereHas('category', function ($q) {
                $q->where('is_display', '1');
            })
            ->where('is_edited', '1')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($subQuery) use ($search) {
                    $subQuery->where('keywords', 'like', "%{$search}%")
                        ->orWhere('title', 'like', "%{$search}%")
                        ->orWhereHas('category', function ($categoryQuery) use ($search) {
                            $categoryQuery->where('category_name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('collection', function ($collectionQuery) use ($search) {
                            $collectionQuery->where('name', 'like', "%{$search}%");
                        });
                });
            });

        if ($type !== 'all') {
            $query->where('type', $type);
        }

        // Get keywords + also title/category/collection if needed
        $results = $query->take(10)->get();

        $suggestions = [];

        foreach ($results as $item) {

            if ($item->keywords) {
                foreach (explode(',', $item->keywords) as $word) {
                    $word = trim($word);
                    if ($word !== '') {
                        $suggestions[] = $word;
                    }
                }
            }

            if ($item->title) {
                $suggestions[] = $item->title;
            }

            if ($item->category && $item->category->category_name) {
                $suggestions[] = $item->category->category_name;
            }

            if ($item->collection && $item->collection->name) {
                $suggestions[] = $item->collection->name;
            }
        }

        // Remove duplicates
        $suggestions = array_unique($suggestions);

        // Filter based on search
        if ($search) {
            $suggestions = array_filter($suggestions, function ($word) use ($search) {
                return stripos($word, $search) !== false;
            });
        }

        return response()->json(array_values($suggestions));
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

<?php

namespace App\Http\Controllers;

use App\Models\BatchFile;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionsController extends Controller
{
    public function index()
    {
        $title = 'Collection';
        $page = 'front.collection';
        $js = ['home'];
        $userId = Auth::id();

        $CollectionList = Collection::Orderby('id', 'desc')->get();
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
        return view("layouts.front.layout", compact('title', 'page', 'CollectionList', 'js', 'trendingTags'));
    }
}

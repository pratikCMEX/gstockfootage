<?php

namespace App\Http\Controllers;

use App\Models\Favorites;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{

    public function index()
    {
        $title = 'Home';
        $page = 'front.favorites';
        $js = ['home', 'favorites'];

        $userId = Auth::id();

        // $js = [''];

        // $products = Favorites::with('product')
        //     ->where('user_id', $userId)
        //     ->get();
        $products = Product::with(['favorites', 'category'])
            ->whereHas('favorites', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->get();

        return view("layouts.front.layout", compact('title', 'page', 'products', 'js'));
    }
    public function addToFavorite(Request $request)
    {
        $user = auth()->user();
        $product_id = $request->product_id;
        $productType = $request->product_type;

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found ...Please login first']);
        }

        $product = Product::find($product_id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found']);
        }

        $existingFavorite = Favorites::where('product_id', $product_id)
            ->where('user_id', $user->id)
            ->where('product_type', $productType)
            ->first();

        if ($existingFavorite) {
            // Remove from favorites
            $existingFavorite->delete();
            return response()->json(['success' => true, 'message' => 'Product removed from favorites', 'action' => 'removed']);
        }

        // Add to favorites
        Favorites::create([
            'product_id' => $product_id,
            'user_id' => $user->id,
            'product_type' => $productType
        ]);

        return response()->json(['success' => true, 'message' => 'Product added to favorites successfully', 'action' => 'added']);
    }

    public function removeFavorite(Request $request)
    {
        $user = auth()->user();
        $id = decrypt($request->id);


        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found ...Please login first']);
        }

        $existingFavorite = Favorites::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingFavorite) {
            // Remove from favorites
            $existingFavorite->delete();
            return response()->json(['success' => true, 'message' => 'Product removed from favorites', 'action' => 'removed']);
        }

        return response()->json(['success' => false, 'message' => 'Product not found in favorites']);
    }
}


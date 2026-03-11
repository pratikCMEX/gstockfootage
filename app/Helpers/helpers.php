<?php

use App\Models\Banner;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

function formatFileSize($bytes)
{
    if ($bytes >= 1048576) {
        return round($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return round($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' B';
    }
}

function duration($seconds)
{
    return gmdate('H:i:s', $seconds);
}

function getCategory()
{
    return Category::all();
}
function mergeSessionCart()
{
    if (!session()->has('cart')) return;
    $sessionCart = session()->get('cart');
    $user_id = Auth::id();

    foreach ($sessionCart as $item) {

        $existing = Cart::where('user_id', $user_id)
            ->where('product_id', $item['product_id'])
            ->first();

        if ($existing) {
            // $existing->increment('qty', $item['qty']);                                                                                                   
            session()->forget('cart');
        } else {
            Cart::create([
                'user_id' => $user_id,
                'product_id' => $item['product_id'],
                'qty' => $item['qty']
            ]);
        }
    }
    session()->forget('cart');
}


function getCartItems()
{
    $items = [];
    $total = 0;
    if (Auth::check()) {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        foreach ($cartItems as $cart) {
            if (!$cart->product) continue;
            $product = $cart->product;
            $items[] = [
                'id'    => $product->id,
                'title' => $product->name,
                'price' => $product->price,
                'type' => $product->type,
                'qty'   => $cart->qty,
                'low_path' => $product->low_path,
                'thumbnail_path' => $product->thumbnail_path,
                'size'  => $product->width . ' x ' . $product->height,
                'quality'  => 'HD Quality',
                'subtotal' => $product->price * $cart->qty,
            ];
            $total += $product->price * $cart->qty;
        }
    } else {
        $sessionCart = session()->get('cart', []);
        if (!empty($sessionCart)) {
            $productIds = array_keys($sessionCart);
            $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

            foreach ($sessionCart as $productId => $cart) {
                if (!isset($products[$productId])) continue;
                $product = $products[$productId];
                $items[] = [
                    'id'    => $product->id,
                    'title' => $product->name,
                    'price' => $product->price,
                    'type' => $product->type,
                    'qty'   => $cart['qty'],
                    'low_path' => $product->low_path,
                    'thumbnail_path' => $product->thumbnail_path,
                    'size'  => $product->width . ' x ' . $product->height,
                    'quality'  => 'HD Quality',
                    'subtotal' => $product->price * $cart['qty'],
                ];
                $total += $product->price * $cart['qty'];
            }
        }
    }

    return [
        'items' => $items,
        'count' => count($items),
        'total' => $total,
    ];
}

function getBanner()
{
    $banner = Banner::where('status', '1')->latest()->first();
    return $banner;
}

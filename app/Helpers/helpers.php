<?php

use App\Models\Cart;
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
                'qty'   => $cart->qty,
                'image' => asset('uploads/products/' . $product->image),
                'size'  => $product->width . ' x ' . $product->height,
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
                    'qty'   => $cart['qty'],
                    'image' => asset('uploads/products/' . $product->image),
                    'size'  => $product->width . ' x ' . $product->height,
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

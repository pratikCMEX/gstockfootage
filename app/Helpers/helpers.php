<?php

use App\Models\Cart;
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

<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = [];
        $total = 0;
        if (Auth::check()) {
            $cartItems = Cart::with('product')
                ->where('user_id', Auth::id())
                ->get();

            foreach ($cartItems as $item) {
                $total += $item->product->price * $item->qty;
            }
        } else {
            $sessionCart = session()->get('cart', []);

            foreach ($sessionCart as $item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    $item['product'] = $product;
                    $item['qty'] = $item['qty'];
                    $cartItems[] = (object)$item;
                    $total += $product->price * $item['qty'];
                }
            }
        }

        return view('frontend.checkout.index', compact('cartItems', 'total'));
    }
}

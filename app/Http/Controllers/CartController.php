<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product_id = $request->product_id;
        $qty        = $request->qty ?? 1;
        if (Auth::check()) {
            $user_id = Auth::id();
            $cartItem = Cart::where('user_id', $user_id)
                ->where('product_id', $product_id)
                ->first();

            if ($cartItem) {
                return response()->json([
                    'status' => false,
                    'message' => 'Product already added to cart'
                ]);
            }

            Cart::create([
                'user_id' => $user_id,
                'product_id' => $product_id,
                'qty' => $qty
            ]);

            $this->mergeSessionCart();

            return response()->json([
                'status' => true,
                'message' => 'Product added to cart'
            ]);
        }

        $cart = session()->get('cart', []);
        if (isset($cart[$product_id])) {
            return response()->json([
                'status' => false,
                'message' => 'Product already added to cart'
            ]);
        }
        $cart[$product_id] = [
            "product_id" => $product_id,
            "qty" => $qty
        ];

        session()->put('cart', $cart);

        return response()->json([
            'status' => true,
            'message' => 'Product added to cart'
        ]);
    }


    private function mergeSessionCart()
    {
        if (!session()->has('cart')) return;
        $sessionCart = session()->get('cart');
        $user_id = Auth::id();

        foreach ($sessionCart as $item) {

            $existing = Cart::where('user_id', $user_id)
                ->where('product_id', $item['product_id'])
                ->first();

            if ($existing) {
                $existing->increment('qty', $item['qty']);
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

    public function cartList()
    {
        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())
                ->with('product')
                ->get();
        } else {
            $cart = session()->get('cart', []);
            $cartItems = collect($cart);
        }
        return view('cart.index', compact('cartItems'));
    }
}

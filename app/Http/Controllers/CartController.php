<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $user_id = Auth::id();
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

            mergeSessionCart();

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

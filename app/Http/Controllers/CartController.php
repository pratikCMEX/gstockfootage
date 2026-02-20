<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $user_id = Auth::id();
        $product_id = $request->product_id;
        $product = Product::findOrFail($request->product_id);

        $qty  = $request->qty ?? 1;
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
                'message' => 'Product added to cart',
                'product' => [
                    'id'    => $product->id,
                    'title' => $product->name,
                    'price' => $product->price,
                    'image' => asset('uploads/products/' . $product->image),
                    'size'  => $product->width . ' x ' . $product->height
                ]
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

        // return response()->json([
        //     'status' => true,
        //     'message' => 'Product added to cart'
        // ]);
        return response()->json([
            'status' => true,
            'message' => 'Product added to cart',
            'product' => [
                'id'    => $product->id,
                'title' => $product->name,
                'price' => $product->price,
                'image' => asset('uploads/products/' . $product->image),
                'size'  => $product->width . ' x ' . $product->height
            ]
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
    public function removeFromCart(Request $request)
    {
        $product_id = $request->product_id;
        if (Auth::check()) {

            Cart::where('user_id', Auth::id())
                ->where('product_id', $product_id)
                ->delete();

            return response()->json([
                'status' => true,
                'message' => 'Item removed from cart'
            ]);
        }
        $cart = session()->get('cart', []);

        if (isset($cart[$product_id])) {
            unset($cart[$product_id]);
            session()->put('cart', $cart);
        }

        return response()->json([
            'status' => true,
            'message' => 'Item removed from cart'
        ]);
    }
}

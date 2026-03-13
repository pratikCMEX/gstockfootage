<?php

namespace App\Http\Controllers;

use App\Models\BatchFile;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $title = 'Cart';
        $page = 'front.view_cart';

        $cart = getCartItems();

        return view("layouts.front.layout", compact('title', 'page', 'cart'));
    }
    public function addToCart(Request $request)
    {
        $user_id = Auth::id();
        $product_id = $request->product_id;
       
        $product = BatchFile::findOrFail($request->product_id);
       
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
                    'type' => $product->type,
                    'low_path' => asset('uploads/images/low/' . $product->low_path),
                    'thumbnail_path' => asset('uploads/videos/thumbnails/' . $product->low_path),
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
                'type' => $product->type,
                'low_path' => asset('uploads/images/low/' . $product->low_path),
                'thumbnail_path' => asset('uploads/videos/thumbnails/' . $product->low_path),
                'size'  => $product->width . ' x ' . $product->height
            ]
        ]);
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    public function list()
    {
        $orders = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'orders' => $orders
        ]);
    }
    public function store()
    {
        try {
            DB::beginTransaction();

            $cartItems = [];
            $total = 0;

            if (Auth::check()) {
                $cartItems = Cart::with('product')
                    ->where('user_id', Auth::id())->get();
            } else {
                $sessionCart = session()->get('cart', []);
                foreach ($sessionCart as $item) {
                    $product = Product::find($item['product_id']);
                    if ($product) {
                        $item['product'] = $product;
                        $cartItems[] = (object)$item;
                    }
                }
            }

            if (count($cartItems) == 0) {
                return response()->json(['message' => 'Cart is empty'], 400);
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD' . time(),
                'total_amount' => 0
            ]);
            foreach ($cartItems as $item) {
                $price = $item->product->price;
                $qty   = $item->qty ?? $item->quantity ?? 1;

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product->id,
                    'qty' => $qty,
                    'price' => $price
                ]);
                $total += $price * $qty;
            }

            $order->update(['total_amount' => $total]);
            if (Auth::check()) {
                Cart::where('user_id', Auth::id())->delete();
            } else {
                session()->forget('cart');
            }
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Order placed successfully',
                'order_id' => $order->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

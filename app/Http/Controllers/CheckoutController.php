<?php

namespace App\Http\Controllers;

use App\Models\BatchFile;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    public function index()
    {
        $title = 'Checkout';
        $page = 'front.checkout';
        $js = ['checkout'];


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
                $product = BatchFile::find($item['product_id']);
                if ($product) {
                    $item['product'] = $product;
                    $item['qty'] = $item['qty'];
                    $cartItems[] = (object)$item;
                    $total += $product->price * $item['qty'];
                }
            }
        }
        // dd($cartItems->product->type);
        return view("layouts.front.layout", compact('title', 'page', 'cartItems', 'total', 'js'));
    }

    public function downloadFile(Request $request)
    {
        $request->validate([
            'path' => 'required|string',
            'name' => 'required|string',
        ]);

        $path = $request->path;

        if (!Storage::disk('s3')->exists($path)) {
            abort(404, 'File not found.');
        }

        $stream = Storage::disk('s3')->readStream($path);

        return response()->stream(function () use ($stream) {
            fpassthru($stream);
        }, 200, [
            'Content-Type'        => Storage::disk('s3')->mimeType($path),
            'Content-Disposition' => 'attachment; filename="' . $request->name . '"',
            'Cache-Control'       => 'no-cache, no-store, must-revalidate',
        ]);
    }
}

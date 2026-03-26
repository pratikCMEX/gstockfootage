<?php

use App\Models\Banner;
use App\Models\BatchFile;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Collection;
use App\Models\License_master;
use App\Models\Product;
use App\Models\Social_links;
use App\Models\User_subscriptions;
use Illuminate\Support\Facades\Auth;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

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
function formatPhoneByCountry($phone, $countryCode)
{
    if (!$phone || !$countryCode) return '-';

    try {
        $phoneUtil   = PhoneNumberUtil::getInstance();
        $fullNumber  = $countryCode . preg_replace('/[^0-9]/', '', $phone);
        $parsed      = $phoneUtil->parse($fullNumber, null);

        // NATIONAL format = country-specific format
        return $phoneUtil->format($parsed, PhoneNumberFormat::NATIONAL);
    } catch (\Exception $e) {
        return $phone; // fallback to raw number
    }
}
function duration($seconds)
{
    return gmdate('H:i:s', $seconds);
}

function getCategory()
{
    return Category::where('is_display', '1')->get();
}
function getSocialLinks()
{
    return Social_links::first();
}

function isInCart($product_id)
{
    $user_id = Auth::id();

    // ── Logged in → check DB ─────────────────────
    if ($user_id) {
        return Cart::where('user_id', $user_id)
            ->where('product_id', $product_id)
            ->exists();
    }

    // ── Guest → check session ────────────────────
    $cart = session()->get('cart', []);
    return isset($cart[$product_id]);
}
function getHighProductQualityPrice()
{
    $record = License_master::with('productQuality')
        ->whereHas('productQuality', function ($q) {
            $q->where('name', 'High');
        })
        ->first();

    return $record ? $record->price : null;
}


function checkSubscription($user_id)
{
    $subscription = User_subscriptions::where('user_id', $user_id)
        ->where('status', 'active')
        ->where('end_date', '>', now())
        ->first();

    return $subscription;
}

function getCollections()
{
    return Collection::get();
}
function mergeSessionCart()
{
    if (!session()->has('cart'))
        return;
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
        $cartItems = Cart::with(['product.category'])
            ->where('user_id', Auth::id())
            ->whereHas('product', function ($q) {
                $q->whereHas('category', function ($q2) {
                    $q2->where('is_display', '1');
                });
            })
            ->get();


        foreach ($cartItems as $cart) {
            if (!$cart->product)
                continue;
            $product = $cart->product;
            $items[] = [
                'id' => $product->id,
                'title' => $product->title,
                'price' => $product->price,
                'type' => $product->type,
                'qty' => $cart->qty,
                'low_path' => $product->low_path,
                'mid_path' => $product->mid_path,
                'thumbnail_path' => $product->thumbnail_path,
                'size' => ($product->height ?? 0) . ' x ' . ($product->width ?? 0) . ' (H x W)',
                'quality' => 'HD Quality',
                'subtotal' => $product->price * $cart->qty,
            ];
            $total += $product->price * $cart->qty;
        }
    } else {
        $sessionCart = session()->get('cart', []);

        if (!empty($sessionCart)) {
            $productIds = array_keys($sessionCart);
            $products = BatchFile::with('category')->whereIn('id', $productIds)
                ->whereHas('category', function ($q) {
                    $q->where('is_display', '1');
                })
                ->get()->keyBy('id');

            foreach ($sessionCart as $productId => $cart) {
                if (!isset($products[$productId]))
                    continue;
                $product = $products[$productId];
                $items[] = [
                    'id' => $product->id,
                    'title' => $product->title,
                    'price' => $product->price,
                    'type' => $product->type,
                    'qty' => $cart['qty'],
                    'low_path' => $product->low_path,
                    'mid_path' => $product->mid_path,
                    'thumbnail_path' => $product->thumbnail_path,
                    'size' => ($product->height ?? 0) . ' x ' . ($product->width ?? 0) . ' (H x W)',
                    'quality' => 'HD Quality',
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

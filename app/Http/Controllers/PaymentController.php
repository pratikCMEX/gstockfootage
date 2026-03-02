<?php

namespace App\Http\Controllers;

use App\Mail\OrderReceiptMail;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function processCheckout(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        $cart = getCartItems();

        if (empty($cart['items'])) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        $data = Stripe::setApiKey(config('services.stripe.secret'));

        $lineItems = [];

        foreach ($cart['items'] as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item['title'],
                    ],
                    'unit_amount' => 2 * 100,
                    // 'unit_amount' => $item['price'] * 100, 
                ],
                'quantity' => $item['qty'],
            ];
        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'customer_email' => $request->email,
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success'),
            'cancel_url' => route('checkout.cancel'),
        ]);

        return response()->json([
            'id' => $session->id
        ]);
    }

    public function success(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        // $session = Session::retrieve($request->session_id);

        // if ($session->payment_status !== 'paid') {
        //     return redirect()->route('checkout.cancel');
        // }



        return redirect()->route('home')->with('msg_success', 'Payment successful!');
    }

    // public function webhook(Request $request)
    // {
    //     $payload = $request->getContent();
    //     $event = json_decode($payload);

    //     if ($event->type == 'checkout.session.completed') {

    //         $session = $event->data->object;

    //         if ($session->payment_status == 'paid') {

    //             $cart = getCartItems();

    //             $order = Order::create([
    //                 'user_id' => Auth::id(),
    //                 'order_number' => 'ORD-' . strtoupper(uniqid()),
    //                 'total_amount' => $cart['total'],
    //                 'stripe_session_id' => $session->id,
    //                 'email' => $session->customer_email,
    //                 'payment_status' => 'paid',
    //                 'order_status' => 'completed',
    //             ]);

    //             foreach ($cart['items'] as $item) {
    //                 OrderDetail::create([
    //                     'order_id' => $order->id,
    //                     'product_id' => $item['id'],
    //                     'price' => $item['price'],
    //                     'qty' => $item['qty'],
    //                 ]);
    //             }

    //             $order = Order::with('order_details.product')->find($order->id);

    //             Mail::to($order->email)->send(new OrderReceiptMail($order));

    //             if (Auth::check()) {
    //                 Cart::where('user_id', Auth::id())->delete();
    //             } else {
    //                 session()->forget('cart');
    //             }
    //         }
    //     }

    //     return response()->json(['status' => 'success']);
    // }

    public function cancel()
    {
        return redirect()->back()->with('msg_error', 'Payment cancelled.');
    }

    public function handleWebhook(Request $request)
    {

        Log::info("🎬 webHook has called");
        $payload = $request->getContent();
        $sig_header = $request->server('HTTP_STRIPE_SIGNATURE');
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\Exception $e) {
            return response('Invalid signature', 400);
        }

        if ($event->type === 'checkout.session.completed') {

            $session = $event->data->object;

            $cart = getCartItems();

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'total_amount' => $cart['total'],
                'stripe_session_id' => $session->id,
                'email' => $session->customer_email,
                'payment_status' => 'paid',
                'order_status' => 'completed',
            ]);

            foreach ($cart['items'] as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'price' => $item['price'],
                    'qty' => $item['qty'],
                ]);
            }

            if (Auth::check()) {
                Cart::where('user_id', Auth::id())->delete();
            } else {
                session()->forget('cart');
            }
        }

        return response('Webhook handled', 200);
    }
}

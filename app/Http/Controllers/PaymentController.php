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
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;



use Illuminate\Support\Facades\Log;



class PaymentController extends Controller
{

    // public function processCheckout(Request $request)
    // {

    //     $request->validate([

    //         'email' => 'required|email'

    //     ]);

    //     $cart = getCartItems();



    //     if (empty($cart['items'])) {

    //         return response()->json(['error' => 'Cart is empty'], 400);

    //     }



    //     $data = \Stripe\Stripe::setApiKey(config('services.stripe.secret'));



    //     $lineItems = [];



    //     foreach ($cart['items'] as $item) {

    //         $lineItems[] = [

    //             'price_data' => [

    //                 'currency' => 'usd',

    //                 'product_data' => [

    //                     'name' => $item['title'],

    //                 ],

    //                 // 'unit_amount' => 2 * 100,

    //                 'unit_amount' => $item['price'] * 100,

    //             ],

    //             'quantity' => $item['qty'],
    //         ];
    //     }



    //     $session = \Stripe\Checkout\Session::create([

    //         'payment_method_types' => ['card'],

    //         'customer_email' => $request->email,

    //         'line_items' => $lineItems,

    //         'mode' => 'payment',

    //         'success_url' => route('checkout.success'),

    //         'cancel_url' => route('checkout.cancel'),

    //     ]);



    //     return response()->json([

    //         'id' => $session->id

    //     ]);

    // }



    // public function success(Request $request)
    // {

    //     \Stripe\Stripe::setApiKey(config('services.stripe.secret'));



    //     // $session = Session::retrieve($request->session_id);



    //     // if ($session->payment_status !== 'paid') {

    //     //     return redirect()->route('checkout.cancel');

    //     // }







    //     return redirect()->route('home')->with('msg_success', 'Payment successful!');

    // }



    // // public function webhook(Request $request)

    // // {

    // //     $payload = $request->getContent();

    // //     $event = json_decode($payload);



    // //     if ($event->type == 'checkout.session.completed') {



    // //         $session = $event->data->object;



    // //         if ($session->payment_status == 'paid') {



    // //             $cart = getCartItems();



    // //             $order = Order::create([

    // //                 'user_id' => Auth::id(),

    // //                 'order_number' => 'ORD-' . strtoupper(uniqid()),

    // //                 'total_amount' => $cart['total'],

    // //                 'stripe_session_id' => $session->id,

    // //                 'email' => $session->customer_email,

    // //                 'payment_status' => 'paid',

    // //                 'order_status' => 'completed',

    // //             ]);



    // //             foreach ($cart['items'] as $item) {

    // //                 OrderDetail::create([

    // //                     'order_id' => $order->id,

    // //                     'product_id' => $item['id'],

    // //                     'price' => $item['price'],

    // //                     'qty' => $item['qty'],

    // //                 ]);

    // //             }



    // //             $order = Order::with('order_details.product')->find($order->id);



    // //             Mail::to($order->email)->send(new OrderReceiptMail($order));



    // //             if (Auth::check()) {

    // //                 Cart::where('user_id', Auth::id())->delete();

    // //             } else {

    // //                 session()->forget('cart');

    // //             }

    // //         }

    // //     }



    // //     return response()->json(['status' => 'success']);

    // // }



    // public function cancel()
    // {

    //     return redirect()->back()->with('msg_error', 'Payment cancelled.');

    // }



    // public function handleWebhook(Request $request)
    // {



    //     Log::info("🎬 webHook has called");

    //     $payload = $request->getContent();

    //     $sig_header = $request->server('HTTP_STRIPE_SIGNATURE');

    //     $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');



    //     try {

    //         $event = \Stripe\Webhook::constructEvent(

    //             $payload,

    //             $sig_header,

    //             $endpoint_secret

    //         );

    //     } catch (\Exception $e) {

    //         return response('Invalid signature', 400);

    //     }



    //     if ($event->type === 'checkout.session.completed') {



    //         $session = $event->data->object;



    //         // if ($session->payment_status == 'paid') {





    //     }



    //     return response('Webhook handled', 200);

    // }


    public function processCheckout(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $cart = getCartItems();

        if (empty($cart['items'])) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $lineItems = [];

        foreach ($cart['items'] as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item['title'],
                    ],
                    'unit_amount' => $item['price'] * 100,
                ],
                'quantity' => $item['qty'],
            ];
        }

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'customer_email' => $request->email,
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success'),
            'cancel_url' => route('checkout.cancel'),
        ]);

        // ── Store cart in cache keyed by Stripe session ID ────────────────────────
        Cache::put('stripe_cart_' . $session->id, $cart, now()->addHours(24));

        Log::info("🛒 Cart stored in cache", [
            'session_id' => $session->id,
            'items' => count($cart['items']),
            'total' => $cart['total'] ?? 0,
        ]);

        return response()->json([
            'id' => $session->id
        ]);
    }

    public function success(Request $request)
    {
        return redirect()->route('home')->with('msg_success', 'Payment successful! Your order has been placed.');
    }

    public function cancel()
    {
        return redirect()->back()->with('msg_error', 'Payment cancelled.');
    }

    public function handleWebhook(Request $request)
    {
        Log::info(" Webhook received");

        $payload = $request->getContent();
        $sigHeader = $request->server('HTTP_STRIPE_SIGNATURE');
        $endpointSecret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sigHeader,
                $endpointSecret
            );
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error(" Webhook signature invalid", ['error' => $e->getMessage()]);
            return response('Invalid signature', 400);
        } catch (\Exception $e) {
            Log::error(" Webhook error", ['error' => $e->getMessage()]);
            return response('Webhook error', 400);
        }

        Log::info(" Webhook event received", ['type' => $event->type]);

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            Log::info(" Session data", [
                'session_id' => $session->id,
                'payment_status' => $session->payment_status,
                'email' => $session->customer_email,
            ]);

            if ($session->payment_status !== 'paid') {
                Log::warning(" Payment not paid yet", ['status' => $session->payment_status]);
                return response('Webhook handled', 200);
            }

            // Prevent duplicate order
            $existingOrder = Order::where('stripe_session_id', $session->id)->first();
            if ($existingOrder) {
                Log::warning(" Order already exists", ['session_id' => $session->id]);
                return response('Webhook handled', 200);
            }

            // Get cart from cache
            $cartData = Cache::get('stripe_cart_' . $session->id);

            Log::info(" Cart data from cache", [
                'session_id' => $session->id,
                'found' => $cartData ? 'YES' : 'NO',
                'items' => $cartData ? count($cartData['items']) : 0,
            ]);

            if (!$cartData || empty($cartData['items'])) {
                Log::error(" Cart data missing from cache", ['session_id' => $session->id]);
                return response('Cart data missing', 400);
            }

            DB::beginTransaction();

            try {
                // Find user by email
                $user = User::where('email', $session->customer_email)->first();

                // Create Order
                $order = Order::create([
                    'user_id' => $user?->id,
                    'order_number' => 'ORD-' . strtoupper(uniqid()),
                    'total_amount' => $session->amount_total / 100,
                    'stripe_session_id' => $session->id,
                    'email' => $session->customer_email,
                    'payment_status' => 'paid',
                    'order_status' => 'completed',
                ]);

                Log::info(" Order created", [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'user_id' => $order->user_id,
                ]);

                // Create Order Details
                foreach ($cartData['items'] as $item) {
                    OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $item['id'],
                        'price' => $item['price'],
                        'qty' => $item['qty'],
                    ]);

                    Log::info(" Order detail created", [
                        'product_id' => $item['id'],
                        'price' => $item['price'],
                        'qty' => $item['qty'],
                    ]);
                }

                // Clear Cart
                if ($user) {
                    // Logged in user — clear DB cart
                    Cart::where('user_id', $user->id)->delete();
                    Log::info(" DB cart cleared", ['user_id' => $user->id]);
                }

                // Clear cache cart regardless
                Cache::forget('stripe_cart_' . $session->id);
                Log::info(" Cache cart cleared");

                DB::commit();

                // Send Receipt Email
                try {
                    $orderWithDetails = Order::with('order_details.product')->find($order->id);
                    Mail::to($order->email)->send(new OrderReceiptMail($orderWithDetails));
                    Log::info(" Receipt email sent", ['email' => $order->email]);
                } catch (\Exception $mailException) {
                    Log::error(" Email failed", ['error' => $mailException->getMessage()]);
                }

                Log::info(" Webhook processing completed", ['order_id' => $order->id]);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error(" Order creation failed", [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                return response('Order processing failed', 500);
            }
        }

        return response('Webhook handled', 200);
    }
}

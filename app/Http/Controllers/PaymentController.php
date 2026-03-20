<?php



namespace App\Http\Controllers;



use App\Mail\OrderReceiptMail;
use App\Models\BatchFile;
use Illuminate\Http\Request;

use Stripe\Stripe;

use Stripe\Checkout\Session;

use App\Models\Order;

use App\Models\OrderItem;

use App\Models\Cart;

use App\Models\OrderDetail;

use App\Models\Product;
use App\Models\User;
use App\Models\User_subscriptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;



use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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


        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Check Subscription & Remaining Clips
        |--------------------------------------------------------------------------
        */
        $subscription = User_subscriptions::where('user_id', $user->id)
            ->where('status', 'active')
            ->where('end_date', '>=', now())
            ->first();
        if ($subscription && $subscription->remaining_clips > 0) {

            $cartItems     = array_values($cart['items']);
            $cartItemCount = count($cartItems);
            $remainingClips = $subscription->remaining_clips;

            // ── How many can subscription cover ──
            $coveredCount = min($remainingClips, $cartItemCount);
            $paidCount    = $cartItemCount - $coveredCount;

            $subscriptionItems = array_slice($cartItems, 0, $coveredCount);
            $paymentItems      = array_slice($cartItems, $coveredCount);

            $files = [];

            // ── Process subscription items ──
            if ($coveredCount > 0) {

                $subscription->used_clips      += $coveredCount;
                $subscription->remaining_clips -= $coveredCount;
                $subscription->save();

                $order = Order::create([
                    'user_id'           => $user->id,
                    'order_number'      => 'ORD-' . strtoupper(uniqid()),
                    'total_amount'      => collect($subscriptionItems)->sum(fn($i) => $i['price'] * $i['qty']),
                    'stripe_session_id' => null,
                    'email'             => $user->email,
                    'payment_status'    => 'paid',
                    'order_status'      => 'completed',
                ]);

                foreach ($subscriptionItems as $item) {
                    OrderDetail::create([
                        'order_id'   => $order->id,
                        'product_id' => $item['id'],
                        'price'      => $item['price'],
                        'qty'        => $item['qty'],
                    ]);

                    $file = BatchFile::where('id', $item['id'])
                        ->select('id', 'file_path', 'file_name', 'title')
                        ->first();

                    if ($file) {
                        $files[] = [
                            'file_name' => $file->file_name,
                            'file_path' => $file->file_path,
                            'title'     => $file->title,
                        ];
                    }

                    BatchFile::where('id', $item['id'])
                        ->increment('downloads', $item['qty'] ?? 1);
                }

                try {
                    $orderWithDetails = Order::with('order_details.product')->find($order->id);

                    Mail::to($order->email)->send(new OrderReceiptMail($orderWithDetails));
                    Log::info('Email sent');
                } catch (\Exception $mailException) {
                    Log::error('Email failed', ['error' => $mailException->getMessage()]);
                }
            }

            // ── All covered — no payment needed ──
            if ($paidCount === 0) {
                Cart::where('user_id', $user->id)->delete();
                return response()->json([
                    'status'    => 'subscription',
                    'img_paths' => $files,
                    'message'   => 'All items downloaded via subscription.',
                ]);
            }

            // ── Some need payment — build paid items info ──
            $paidItemTitles = collect($paymentItems)->pluck('title')->implode(', ');

            // ── Remove subscription items from cart, keep only paid items ──
            // Store partial cart for Stripe webhook
            $partialCart          = $cart;
            $partialCart['items'] = array_values($paymentItems);

            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

            $lineItems = [];
            foreach ($paymentItems as $item) {
                $lineItems[] = [
                    'price_data' => [
                        'currency'     => 'usd',
                        'product_data' => ['name' => $item['title']],
                        'unit_amount'  => $item['price'] * 100,
                    ],
                    'quantity' => $item['qty'],
                ];
            }

            $token = Str::random(32);
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'customer_email'       => $request->email,
                'line_items'           => $lineItems,
                'mode'                 => 'payment',
                'success_url'          => route('checkout.success') . '?token=' . $token,
                'cancel_url'           => route('checkout.cancel'),
            ]);

            Cache::put('stripe_token_' . $token, $session->id, now()->addHours(2));
            Cache::put('stripe_cart_' . $session->id, $partialCart, now()->addHours(24));

            return response()->json([
                'status'           => 'mixed',
                'id'               => $session->id,
                'img_paths'        => $files,
                'covered_count'    => $coveredCount,
                'paid_count'       => $paidCount,
                'paid_item_titles' => $paidItemTitles,
            ]);
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


        $token = Str::random(32);  // short random token — safe for URLs, WAF won't flag
        Cache::put('stripe_token_' . $token, null, now()->addHours(2));
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'customer_email' => $request->email,
            'line_items' => $lineItems,
            'mode' => 'payment',
            // 'success_url' => route('checkout.success'),
            'success_url'          => route('checkout.success') . '?token=' . $token,

            'cancel_url' => route('checkout.cancel'),
        ]);

        // ── Store cart in cache keyed by Stripe session ID ────────────────────────
        Cache::put('stripe_token_' . $token, $session->id, now()->addHours(2));

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
        $token = $request->query('token'); // short safe token from URL

        // Look up the real Stripe session_id from cache
        $sessionId = $token ? \Cache::get('stripe_token_' . $token) : null;

        return view('front.checkout_success', compact('sessionId', 'token'));
    }
    public function cancel()
    {
        return redirect()->back()->with('msg_error', 'Payment cancelled.');
    }

    public function downloadFile(Request $request)
    {
        // -------------------------------------------------------
        // PATH 1: Subscription download (already working)
        // Called with ?path=...&name=...
        // -------------------------------------------------------
        if ($request->has('path')) {

            $filePath = $request->query('path');
            $fileName = $request->query('name');

            // Close output buffers to prevent corruption
            while (ob_get_level()) {
                ob_end_clean();
            }

            $s3Client = \Storage::disk('s3')->getClient();
            $bucket   = config('filesystems.disks.s3.bucket');

            $result   = $s3Client->getObject([
                'Bucket' => $bucket,
                'Key'    => $filePath,
            ]);

            $body     = $result['Body'];
            $fileSize = $result['ContentLength'];

            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
            header('Content-Length: ' . $fileSize);
            header('Cache-Control: no-cache, no-store, must-revalidate');
            header('Pragma: no-cache');
            header('Expires: 0');

            $body->rewind();
            while (!$body->eof()) {
                echo $body->read(1024 * 256);
            }

            exit;
        }

        // -------------------------------------------------------
        // PATH 2: Stripe payment download
        // Called with ?sid=...&fid=...
        // -------------------------------------------------------
        $sessionId = $request->query('sid');
        $fileId    = $request->query('fid');

        if (!$sessionId || !$fileId) {
            abort(400, 'Missing parameters');
        }

        // Verify order is paid
        $order = Order::where('stripe_session_id', $sessionId)
            ->where('payment_status', 'paid')
            ->first();

        if (!$order) {
            abort(403, 'Unauthorized');
        }

        // Verify file belongs to this order
        $orderDetail = OrderDetail::where('order_id', $order->id)
            ->where('product_id', $fileId)
            ->first();

        if (!$orderDetail) {
            abort(403, 'File not part of this order');
        }

        // Get file record
        $file = BatchFile::where('id', $fileId)
            ->select('id', 'file_path', 'file_name')
            ->first();

        if (!$file) {
            abort(404, 'File not found');
        }

        // Close output buffers — prevents binary stream corruption
        while (ob_get_level()) {
            ob_end_clean();
        }

        $s3Client = Storage::disk('s3')->getClient();
        $bucket   = config('filesystems.disks.s3.bucket');

        $result   = $s3Client->getObject([
            'Bucket' => $bucket,
            'Key'    => $file->file_path,
        ]);

        $body     = $result['Body'];
        $fileSize = $result['ContentLength'];
        $fileName = $file->file_name;

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Content-Length: ' . $fileSize);
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');

        $body->rewind();
        while (!$body->eof()) {
            echo $body->read(1024 * 256);
        }

        exit;
    }

    public function downloadZip(Request $request)
    {
        while (ob_get_level()) ob_end_clean();

        $files = $request->input('files', []);

        Log::info('downloadZip called', ['file_count' => count($files)]);

        if (empty($files)) {
            return response()->json(['error' => 'No files to download.'], 400);
        }

        if (!class_exists('ZipArchive')) {
            return response()->json(['error' => 'Zip not supported.'], 500);
        }

        $zipName = 'downloads_' . time() . '.zip';
        $zipPath = storage_path('app/temp/' . $zipName);

        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $zip = new \ZipArchive();

        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return response()->json(['error' => 'Could not create zip.'], 500);
        }

        $addedFiles = 0;

        foreach ($files as $fileJson) {
            $file = is_array($fileJson) ? $fileJson : json_decode($fileJson, true);
            $path = $file['path'] ?? null;
            $name = $file['name'] ?? basename($path);

            if (!$path) continue;

            try {
                $contents = Storage::disk('s3')->get($path);
                if ($contents) {
                    $zip->addFromString($name, $contents);
                    $addedFiles++;
                }
            } catch (\Exception $e) {
                Log::error('Failed to add file to zip', ['path' => $path, 'error' => $e->getMessage()]);
            }
        }

        $zip->close();

        if ($addedFiles === 0 || !file_exists($zipPath) || filesize($zipPath) === 0) {
            return response()->json(['error' => 'Zip creation failed.'], 500);
        }

        return response()->download($zipPath, $zipName, [
            'Content-Type'        => 'application/zip',
            'Content-Disposition' => 'attachment; filename="' . $zipName . '"',
        ])->deleteFileAfterSend(true);
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

    public function getOrderFiles(Request $request)
    {
        $sessionId = $request->input('session_id');

        if (!$sessionId) {
            return response()->json(['status' => 'error', 'message' => 'Missing session ID'], 400);
        }

        $order = Order::where('stripe_session_id', $sessionId)
            ->where('payment_status', 'paid')
            ->with('order_details')
            ->first();

        if (!$order) {
            return response()->json(['status' => 'pending']);
        }

        $files = [];

        foreach ($order->order_details as $detail) {
            $file = BatchFile::where('id', $detail->product_id)
                ->select('id', 'file_path', 'file_name')
                ->first();

            if ($file) {
                $files[] = [
                    'file_name'    => $file->file_name,
                    'file_path'    => $file->file_path,
                    'download_url' => url('/download/file')
                        . '?path=' . urlencode($file->file_path)
                        . '&name=' . urlencode($file->file_name),
                ];
            }
        }

        return response()->json([
            'status' => 'ready',
            'files'  => $files,
        ]);
    }
}

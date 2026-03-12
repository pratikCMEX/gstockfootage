<?php

namespace App\Http\Controllers;

use App\Models\License_master;
use App\Models\User_license;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class UserLicenceController extends Controller
{
    public function checkout(Request $request)
    {

        $license = License_master::findOrFail($request->license_id);

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'mode' => 'payment',

            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $license->name,
                        ],
                        'unit_amount' => $license->plan_price * 100,
                    ],
                    'quantity' => 1,
                ]
            ],

            'success_url' => route('license.success') . '?session_id={CHECKOUT_SESSION_ID}&license=' . $license->id,
            'cancel_url' => route('license.cancel'),
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {

        $license = License_master::find($request->license);

        User_license::create([
            'user_id' => auth()->id(),
            'license_id' => $license->id,
            'product_quality_id' => $license->product_quality_id,
            'price' => $license->plan_price,
            'payment_id' => $request->session_id,
            'payment_status' => 'paid'
        ]);

        return redirect()->route('pricing')->with('msg_success', 'License purchased successfully');



    }
    public function cancel()
    {
        return redirect()->route('pricing')->with('msg_error', 'Payment cancelled');

    }
}

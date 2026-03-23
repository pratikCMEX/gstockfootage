<?php

namespace App\Services;

use App\Models\Affiliate;
use App\Models\AffiliateReferral;
use App\Models\AffiliateSetting;
use App\Models\Order;
use App\Models\User;
use Log;

class AffiliateService
{
    public function processCommission(Order $order): void
    {
        Log::info('Entered in process commition');
        //  Get the user who placed the order
        $user = User::find($order->user_id);


        if (!$user || !$user->referred_by) {
            return; //  User was not referred by anyone
        }

        //  Find active affiliate by referral code
        $affiliate = Affiliate::where('referral_code', $user->referred_by)
            ->where('status', 'active')
            ->first();


        Log::info('get affiliate');

        if (!$affiliate) {
            return; //  Affiliate not found or inactive
        }

        //  Check if commission already given for this order
        $alreadyProcessed = AffiliateReferral::where('order_id', $order->id)->exists();

        if ($alreadyProcessed) {
            return; //  Prevent duplicate commission
        }

        //  Get commission amount from settings
        $commissionAmount = AffiliateSetting::latest()
            ->value('commission_amount') ?? 0;

        Log::info('get commissionAmount');
        if ($commissionAmount <= 0) {
            return;
        }

        //  Create referral record
        AffiliateReferral::create([
            'affiliate_id' => $affiliate->id,
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'order_amount' => $order->total_amount,
            'commission_amount' => $commissionAmount,
            'status' => 'pending',
        ]);
        Log::info('create affiliate referral');
        //  Update affiliate totals
        $affiliate->increment('total_earnings', $commissionAmount);
        $affiliate->increment('total_orders');

        Log::info('increase affiliate data');
    }
}
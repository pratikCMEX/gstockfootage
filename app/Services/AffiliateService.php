<?php

namespace App\Services;

use App\Models\Affiliate;
use App\Models\AffiliateReferral;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AffiliateService
{
    public function processCommission(Order $order): void
    {
        $logPrefix = "[AffiliateCommission] Order#{$order->id}";

        Log::info("{$logPrefix} ▶ Started processing commission");

        //  Step 1 - Get user who placed the order
        $user = User::find($order->user_id);

        if (!$user) {
            Log::warning("{$logPrefix} ✘ User not found for user_id: {$order->user_id}");
            return;
        }

        Log::info("{$logPrefix} ✔ User found: {$user->email} (ID: {$user->id})");

        //  Step 2 - Check if user was referred
        if (!$user->referred_by) {
            Log::info("{$logPrefix} ✘ User has no referral code - skipping");
            return;
        }

        Log::info("{$logPrefix} ✔ Referred by code: {$user->referred_by}");

        //  Step 3 - Find active affiliate by referral code
        $affiliate = Affiliate::where('referral_code', $user->referred_by)
            ->where('status', 'active')
            ->first();

        if (!$affiliate) {
            Log::warning("{$logPrefix} ✘ No active affiliate found for code: {$user->referred_by}");
            return;
        }

        Log::info("{$logPrefix} ✔ Affiliate found: ID#{$affiliate->id} | Type: {$affiliate->commission_type} | Value: {$affiliate->commission_value}");

        //  Step 4 - Check duplicate commission for this order
        $alreadyProcessed = AffiliateReferral::where('order_id', $order->id)->exists();

        if ($alreadyProcessed) {
            Log::warning("{$logPrefix} ✘ Commission already processed for this order - skipping");
            return;
        }

        Log::info("{$logPrefix} ✔ No duplicate found - proceeding");

        //  Step 5 - Calculate commission based on affiliate's commission type
        $commissionAmount = 0;

        if ($affiliate->commission_type === 'fixed') {
            //  Fixed $ amount set per affiliate
            $commissionAmount = $affiliate->commission_value;

            Log::info("{$logPrefix} ✔ Fixed commission: \${$commissionAmount}");

        } elseif ($affiliate->commission_type === 'percentage') {
            //  Percentage of order total
            $commissionAmount = round(($order->total_amount * $affiliate->commission_value) / 100, 2);

            Log::info("{$logPrefix} ✔ Percentage commission: {$affiliate->commission_value}% of \${$order->total_amount} = \${$commissionAmount}");
        }

        //  Step 6 - Validate commission amount
        if ($commissionAmount <= 0) {
            Log::warning("{$logPrefix} ✘ Calculated commission is 0 or less - skipping");
            return;
        }

        Log::info("{$logPrefix} ✔ Final commission amount: \${$commissionAmount}");

        //  Step 7 - Create referral record
        $referral = AffiliateReferral::create([
            'affiliate_id'      => $affiliate->id,
            'user_id'           => $order->user_id,
            'order_id'          => $order->id,
            'order_amount'      => $order->total_amount,
            'commission_amount' => $commissionAmount,
            'status'            => 'pending',
        ]);

        Log::info("{$logPrefix} ✔ Referral record created: ID#{$referral->id} | Commission: \${$commissionAmount}");

        //  Step 8 - Update affiliate totals
        $affiliate->increment('total_earnings', $commissionAmount);
        $affiliate->increment('total_referrals');

        $fresh = $affiliate->fresh();

        Log::info("{$logPrefix} ✔ Affiliate totals updated | Total Earnings: \${$fresh->total_earnings} | Total Referrals: {$fresh->total_referrals}");

        Log::info("{$logPrefix}  Commission processed successfully");
    }
}
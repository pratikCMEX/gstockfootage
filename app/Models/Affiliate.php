<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
   protected $fillable = [
    'affiliate_user_id',
    'referral_code',
    'commission_type',
    'commission_value',
    'total_earnings',
    'total_referrals',
    'status',
];
    public function affiliateUser()
    {
        return $this->belongsTo(AffiliateUser::class, 'affiliate_user_id');
    }

    public function referrals()
    {
        return $this->hasMany(AffiliateReferral::class);
    }
    public static function generateReferralCode($name)
    {
        $base = 'AFF-' . strtoupper(substr(preg_replace('/\s+/', '', $name), 0, 4));
        $code = $base . rand(100, 999);

        //  Make sure it's unique
        while (self::where('referral_code', $code)->exists()) {
            $code = $base . rand(100, 999);
        }

        return $code;
    }
}

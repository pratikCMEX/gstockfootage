<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription_plans extends Model
{
    protected $fillable = [

        'name',
        'price',
        'duration_type',
        'duration_type',
        'duration_value',
        'total_clips',
        'price_per_clip',
        'discount_percentage',
        'is_active',
        'stripe_price_id'

    ];
    public function userSubscriptions()
    {
        return $this->hasMany(User_subscriptions::class, 'subscription_plan_id');
    }
}

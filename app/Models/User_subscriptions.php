<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_subscriptions extends Model
{
    protected $fillable = [
        'user_id',
        'subscription_plan_id',
        'start_date',
        'end_date',
        'total_clips',
        'used_clips',
        'remaining_clips',
        'status',
        'amount',
        'payment_gateway',
        'transaction_id',
        'payment_status'


    ];
}

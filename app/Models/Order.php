<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'payment_status',
        'order_status'
    ];

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}

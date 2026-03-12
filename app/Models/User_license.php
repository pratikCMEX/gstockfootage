<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_license extends Model
{
    protected $fillable = [
        'user_id',
        'license_id',
        'product_quality_id',
        'price',
        'payment_id',
        'payment_status'
    ];
}

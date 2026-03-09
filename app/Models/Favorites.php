<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorites extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'product_type',

    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

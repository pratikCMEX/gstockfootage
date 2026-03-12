<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductQuality extends Model
{
    protected $fillable = [
        'name'
    ];

    public function licenseMasters()
    {
        return $this->hasMany(License_master::class, 'product_quality_id');
    }
}

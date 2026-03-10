<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class License_master extends Model
{
    protected $fillable = [
        'name',
        'title',
        'price',
        'plan_price',
        'description',
        'quality',
        'product_quality_id'

    ];

    public function productQuality()
    {
        return $this->belongsTo(ProductQuality::class, 'product_quality_id');
    }

    public function userLicences()
    {
        return $this->hasMany(User_license::class, 'license_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'collection_id',
        'subcategory_id',
        'type',
        'low_path',
        'high_path',
        'thumbnail_path',
        'name',
        'price',
        'width',
        'height',
        'file_size',
        'description',
        'tags',
        'is_display',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }
    public function favorites()
    {
        return $this->hasMany(Favorites::class, 'product_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {

            if ($product->type == "0") {
                @unlink(public_path('uploads/images/high/' . $product->high_path));
                @unlink(public_path('uploads/images/low/' . $product->low_path));
            }

            if ($product->type == "1") {
                @unlink(public_path('uploads/videos/high/' . $product->high_path));
                @unlink(public_path('uploads/videos/low/' . $product->low_path));
                @unlink(public_path('uploads/videos/thumbnails/' . $product->thumbnail_path));
            }
        });
    }

    // public function carts()
    // {
    //     return $this->hasMany(Cart::class);
    // }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';
    protected $fillable = [
        'category_id',
        'collection_id',
        'subcategory_id',
        'image_name',
        'image_price',
        'image_description',
        'tags',
        'low_path',
        'high_path',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }
}

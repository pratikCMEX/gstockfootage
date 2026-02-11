<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'videos';
    protected $fillable = [
        'category_id',
        'low_path',
        'high_path',
        'thumbnail_path'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

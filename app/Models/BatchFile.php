<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchFile extends Model
{
    protected $fillable = [
        'batch_id',
        'type',
        'category_id',
        'subcategory_id',
        'collection_id',
        'user_id',
        'file_code',
        'original_name',
        'file_name',
        'file_path',
        'thumbnail_path',
        'mid_path',
        'preview_path',
        'low_path',
        'file_type',
        'file_size',
        'width',
        'height',
        'duration',
        'status',
        'rejection_reason',
        'title',
        'price',
        'description',
        'date_created',
        'is_edited',
        'country',
        'frame_rate',
        'keywords',
        'orientation',
        'camera_movement',
        'license_type',
        'content_filters',
    ];

    protected $casts = [
        // Automatically encodes array → JSON on save
        // and decodes JSON → array on read
        'content_filters' => 'array',
    ];
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function incrementView(): void
    {
        $this->increment('views'); // atomic SQL increment, no race conditions
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id'); // or your actual column
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
}

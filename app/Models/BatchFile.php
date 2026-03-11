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
        'low_path',
        'file_type',
        'file_size',
        'width',
        'height',
        'duration',
        'status',
        'rejection_reason',
        'title',
        'description',
        'date_created',
        'is_edited',
        'country',
        'frame_rate',
        'keywords',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
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
}

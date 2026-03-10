<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchFile extends Model
{
    protected $fillable = [
        'batch_id',
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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentMaster extends Model
{
    use HasFactory;

    protected $table = 'content_master';
    protected $fillable = [
        'title',
        'sub_title',
        'content'
    ];

    protected $casts = [
        'content' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
 protected $table = 'blogs';
    protected $fillable = [
        'title',
        'description',
        'author_name',
        'author_tag',
        'publish_date',
        
        'image'
    ];

    protected $casts = [
        'publish_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $dates = [
        'publish_date'
    ];
}

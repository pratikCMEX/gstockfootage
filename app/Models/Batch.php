<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = [
        'user_id',
        'batch_code',
        'title',
        'submission_type',
        'brief_code',
        'status',
        'total_files',
    ];
}

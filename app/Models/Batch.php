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

    public function batch_files()
    {
        return $this->hasMany(BatchFile::class, 'batch_id');
    }
}

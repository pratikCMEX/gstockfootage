<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorites extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'type',

    ];
    public function batchFile()
    {
        return $this->belongsTo(BatchFile::class, 'product_id');
    }
}

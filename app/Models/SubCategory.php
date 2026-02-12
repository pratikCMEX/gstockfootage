<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'image'
    ];


    /* SubCategory → belongs to Category */
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
}

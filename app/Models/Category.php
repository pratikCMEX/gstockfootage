<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Category extends Model
{
    use HasFactory, Notifiable;

    //
    protected $fillable = [
        'category_name',
        'category_image',
    ];
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class,'category_id');
    }
}

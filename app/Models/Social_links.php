<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Social_links extends Model
{
    protected $fillable = [
        'instagram_link',
        'facebook_link',
        'twitter_link',
        'linkedin_link',
        'youtube_link'
    ];
}

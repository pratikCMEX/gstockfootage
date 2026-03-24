<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AffiliateUser extends Authenticatable
{
   protected $table = 'affiliate_users';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'country_code',
        'address',
    ];
    protected $hidden = [
        'password',
    ];

    //  Relationship
    public function affiliate()
    {
        return $this->hasOne(Affiliate::class, 'affiliate_user_id');
    }
}

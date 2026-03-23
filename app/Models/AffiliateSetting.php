<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateSetting extends Model
{
    protected $table = 'affiliate_settings';

    protected $fillable = [
        'commission_amount',
    ];
}

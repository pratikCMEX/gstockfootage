<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'company',
        'job_role',
        'job_function',
        'company_size',
        'country',
        'state',
        'product_interest',
        'newsletter'
    ];
}

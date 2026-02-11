<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Transactions extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'user_id',
        'media_id',
        'media_type',
        'amount',
        'payment_method',
        'transaction_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function media()
    {
        if ($this->media_type === '0') {
            return $this->belongsTo(Image::class, 'media_id');
        } else {
            return $this->belongsTo(Video::class, 'media_id');
        }
    }
}

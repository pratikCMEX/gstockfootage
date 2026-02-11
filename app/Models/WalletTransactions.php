<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WalletTransactions extends Model
{
    use HasFactory;

    protected $table = 'wallet_transactions';

    protected $fillable = [
        'user_id',
        'transaction_type',
        'amount',
        'balance_before',
        'balance_after',
        'reference_id',
        'description',
        'status',
    ];

    protected $casts = [
        'amount' => 'float',
        'balance_before' => 'float',
        'balance_after' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

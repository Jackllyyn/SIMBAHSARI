<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankSaldo extends Model
{
    protected $table = 'bank_saldo';
    protected $fillable = ['saldo'];

    // Pastikan saldo selalu float
    protected $casts = [
        'saldo' => 'decimal:2',
    ];
}
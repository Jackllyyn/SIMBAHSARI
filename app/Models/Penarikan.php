<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penarikan extends Model
{
    protected $fillable = ['nasabah_id', 'jumlah', 'tanggal'];

    protected $casts = [
        'tanggal' => 'datetime', // PERBAIKAN: agar bisa ->format()
        'jumlah' => 'decimal:2',
    ];

    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }
}
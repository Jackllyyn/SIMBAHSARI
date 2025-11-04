<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenjualanSampah extends Model
{
    protected $table = 'penjualan_sampahs';

    protected $fillable = ['sampah_id', 'berat', 'total_harga', 'tanggal_penjualan'];

    protected $casts = [
        'tanggal_penjualan' => 'date',
        'total_harga' => 'decimal:2',
        'berat' => 'integer', // Integer only
    ];

    public function sampah()
    {
        return $this->belongsTo(Sampah::class);
    }
}
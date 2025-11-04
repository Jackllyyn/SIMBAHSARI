<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetoranSampah extends Model
{
    use HasFactory;

    protected $fillable = ['nasabah_id', 'sampah_id', 'berat', 'total_harga', 'tanggal_setor'];

    protected $casts = [
        'berat' => 'integer',
        'total_harga' => 'integer',
        'tanggal_setor' => 'date',
    ];

    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }

    public function sampah()
    {
        return $this->belongsTo(Sampah::class);
    }
}
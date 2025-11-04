<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sampah extends Model
{
    use HasFactory;

    // PERBAIKAN: Nama tabel di DB adalah 'sampahs'
    protected $table = 'sampahs';

    protected $fillable = ['jenis_sampah_id', 'nama', 'deskripsi'];

    public function jenisSampah()
    {
        return $this->belongsTo(JenisSampah::class, 'jenis_sampah_id');
    }

    public function setoranSampah()
    {
        return $this->hasMany(SetoranSampah::class, 'sampah_id');
    }

    public function penjualanSampah()
    {
        return $this->hasMany(PenjualanSampah::class, 'sampah_id');
    }
}
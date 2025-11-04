<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSampah extends Model
{
    use HasFactory;

    // PERBAIKAN: Nama tabel di DB adalah 'jenis_sampahs'
    protected $table = 'jenis_sampahs';

    protected $fillable = ['nama', 'harga_per_kg'];

    public function sampahs()
    {
        return $this->hasMany(Sampah::class, 'jenis_sampah_id');
    }
}
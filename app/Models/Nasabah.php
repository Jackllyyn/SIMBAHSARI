<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'alamat',
        'no_telepon',
        'saldo',
        'foto',
    ];

    protected $casts = [
        'saldo' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function setoranSampahs()
    {
        return $this->hasMany(\App\Models\SetoranSampah::class, 'nasabah_id');
    }

    public function penarikans()
    {
        return $this->hasMany(\App\Models\Penarikan::class, 'nasabah_id');
    }

    public function getFotoUrlAttribute(): ?string
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }
}
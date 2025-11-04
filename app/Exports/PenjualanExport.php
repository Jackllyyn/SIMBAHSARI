<?php

namespace App\Exports;

use App\Models\PenjualanSampah;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PenjualanExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return PenjualanSampah::with('sampah.jenisSampah')->get();
    }

    public function headings(): array
    {
        return ['Sampah', 'Jenis', 'Berat (kg)', 'Total Harga (Rp)', 'Tanggal'];
    }

    public function map($p): array
    {
        return [
            $p->sampah->nama,
            $p->sampah->jenisSampah->nama,
            $p->berat,
            $p->total_harga,
            $p->tanggal_penjualan->format('d/m/Y'),
        ];
    }
}
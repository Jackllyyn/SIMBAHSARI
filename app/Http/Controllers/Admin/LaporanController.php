<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SetoranSampah;
use App\Models\PenjualanSampah;
use App\Models\Penarikan;
use App\Models\BankSaldo;
use Illuminate\Http\Request;
use PDF;
use Excel;
use App\Exports\LaporanExport;

class LaporanController extends Controller
{
   public function pdf(Request $request)
{
    $bulan = $request->get('bulan', now()->month);
    $tahun = $request->get('tahun', now()->year); // PASTIKAN INTEGER

    $data = $this->getLaporanData($bulan, $tahun);

    $pdf = PDF::loadView('admin.laporan.pdf', $data)
              ->setPaper('a4', 'landscape');

    return $pdf->stream("Laporan_{$tahun}-{$bulan}.pdf");
}

public function excel(Request $request)
{
    $bulan = $request->get('bulan', now()->month);
    $tahun = $request->get('tahun', now()->year); // PASTIKAN INTEGER

    return Excel::download(new LaporanExport($bulan, $tahun), "Laporan_{$tahun}-{$bulan}.xlsx");
}
    public function getLaporanData($bulan, $tahun)
    {
        $start = "$tahun-$bulan-01";
        $end = date('Y-m-t', strtotime($start));

        $masuk = SetoranSampah::whereBetween('created_at', [$start, $end])->sum('berat') ?? 0;
        $keluar = PenjualanSampah::whereBetween('tanggal_penjualan', [$start, $end])->sum('berat') ?? 0;
        $pendapatan = PenjualanSampah::whereBetween('tanggal_penjualan', [$start, $end])->sum('total_harga') ?? 0;
        $pengeluaran = Penarikan::whereBetween('created_at', [$start, $end])->sum('jumlah') ?? 0;
        $saldo = BankSaldo::first()->saldo ?? 0;

        $penjualan = PenjualanSampah::with(['sampah.jenisSampah'])
            ->whereBetween('tanggal_penjualan', [$start, $end])
            ->get();

        $penarikan = Penarikan::with('nasabah')
            ->whereBetween('created_at', [$start, $end])
            ->get();

        return compact('bulan', 'tahun', 'masuk', 'keluar', 'pendapatan', 'pengeluaran', 'saldo', 'penjualan', 'penarikan');
    }
}
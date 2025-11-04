<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nasabah;
use App\Models\PenjualanSampah;
use App\Models\Penarikan;
use App\Models\Sampah;
use App\Models\SetoranSampah;
use App\Models\BankSaldo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // === STATISTIK UTAMA ===
        $totalSampahMasuk = SetoranSampah::sum('berat') ?? 0;
        $totalSampahKeluar = PenjualanSampah::sum('berat') ?? 0;
        $saldoBank = BankSaldo::first()->saldo ?? 0;
        $jumlahNasabah = Nasabah::count() ?? 0;
        $jumlahJenisSampah = Sampah::count() ?? 0;

        $perPage = 5;

        // === SEARCH & PAGINATION PENJUALAN ===
        $searchPenjualan = $request->get('search_penjualan');
        $penjualanQuery = PenjualanSampah::with(['sampah.jenisSampah'])
            ->when($searchPenjualan, function ($q) use ($searchPenjualan) {
                $q->whereHas('sampah', function ($sq) use ($searchPenjualan) {
                    $sq->where('nama', 'like', "%{$searchPenjualan}%")
                       ->orWhereHas('jenisSampah', function ($jsq) use ($searchPenjualan) {
                           $jsq->where('nama', 'like', "%{$searchPenjualan}%");
                       });
                });
            })
            ->latest();

        $penjualanSampahs = $penjualanQuery->paginate($perPage, ['*'], 'penjualan_page');
        $penjualanSampahs->appends(['search_penjualan' => $searchPenjualan]);

        // === SEARCH & PAGINATION PENARIKAN ===
        $searchPenarikan = $request->get('search_penarikan');
        $penarikanQuery = Penarikan::with('nasabah')
            ->when($searchPenarikan, function ($q) use ($searchPenarikan) {
                $q->whereHas('nasabah', function ($nq) use ($searchPenarikan) {
                    $nq->where('nama', 'like', "%{$searchPenarikan}%");
                });
            })
            ->latest();

        $penarikans = $penarikanQuery->paginate($perPage, ['*'], 'penarikan_page');
        $penarikans->appends(['search_penarikan' => $searchPenarikan]);

        // === GRAFIK BULANAN (12 BULAN TERAKHIR) ===
        $now = Carbon::now();
        $labels = [];
        $sampahData = ['masuk' => [], 'keluar' => []];
        $saldoData = [];
        $keuanganData = ['pendapatan' => [], 'pengeluaran' => []];

        for ($i = 11; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $labels[] = $month->translatedFormat('M Y'); // Jan 2025

            // Sampah Masuk
            $masuk = SetoranSampah::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('berat') ?? 0;
            $sampahData['masuk'][] = $masuk;

            // Sampah Keluar
            $keluar = PenjualanSampah::whereYear('tanggal_penjualan', $month->year)
                ->whereMonth('tanggal_penjualan', $month->month)
                ->sum('berat') ?? 0;
            $sampahData['keluar'][] = $keluar;

            // Pendapatan
            $pendapatan = PenjualanSampah::whereYear('tanggal_penjualan', $month->year)
                ->whereMonth('tanggal_penjualan', $month->month)
                ->sum('total_harga') ?? 0;
            $keuanganData['pendapatan'][] = $pendapatan;

            // Pengeluaran
            $pengeluaran = Penarikan::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('jumlah') ?? 0;
            $keuanganData['pengeluaran'][] = $pengeluaran;

            // Saldo Akhir Bulan
            $endOfMonth = $month->copy()->endOfMonth();
            $saldo = DB::table('bank_saldo')
                ->where('updated_at', '<=', $endOfMonth)
                ->orderBy('updated_at', 'desc')
                ->value('saldo') ?? 0;
            $saldoData[] = $saldo;
        }

        return view('admin.dashboard', compact(
            'totalSampahMasuk',
            'totalSampahKeluar',
            'saldoBank',
            'jumlahNasabah',
            'jumlahJenisSampah',
            'penjualanSampahs',
            'penarikans',
            'searchPenjualan',
            'searchPenarikan',
            'labels',
            'sampahData',
            'saldoData',
            'keuanganData'
        ));
    }
}
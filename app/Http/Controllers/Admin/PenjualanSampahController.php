<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sampah;
use App\Models\PenjualanSampah;
use App\Models\BankSaldo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PenjualanExport;

class PenjualanSampahController extends Controller
{
    public function index(Request $request)
    {
        $query = PenjualanSampah::with(['sampah.jenisSampah']);

        if ($request->filled('search')) {
            $query->whereHas('sampah', fn($q) => $q->where('nama', 'like', "%{$request->search}%"));
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_penjualan', [$request->start_date, $request->end_date]);
        }

        $penjualanSampahs = $query->latest()->get();
        $chartData = $this->getMonthlyChartData();

        return view('admin.penjualan.index', compact('penjualanSampahs', 'chartData'));
    }

    public function create()
    {
        $sampahs = Sampah::with('jenisSampah')->get();
        return view('admin.penjualan.create', compact('sampahs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sampah_id' => 'required|exists:sampahs,id',
            'berat' => 'required|integer|min:1',
            'tanggal_penjualan' => 'required|date',
        ]);

        $sampah = Sampah::findOrFail($request->sampah_id);
        $totalHarga = $request->berat * $sampah->jenisSampah->harga_per_kg;

        DB::transaction(function () use ($request, $totalHarga) {
            PenjualanSampah::create([
                'sampah_id' => $request->sampah_id,
                'berat' => $request->berat,
                'total_harga' => $totalHarga,
                'tanggal_penjualan' => $request->tanggal_penjualan,
            ]);

            $bank = BankSaldo::first() ?? BankSaldo::create(['saldo' => 0]);
            $bank->increment('saldo', $totalHarga);
        });

        $saldoBaru = BankSaldo::first()->saldo ?? 0;

        return redirect()->route('admin.penjualan.index')
            ->with('success', 'Penjualan berhasil ditambahkan!')
            ->with('saldo_update', $saldoBaru);
    }

    public function edit(PenjualanSampah $penjualan)
    {
        $sampahs = Sampah::with('jenisSampah')->get();
        return view('admin.penjualan.edit', compact('penjualan', 'sampahs'));
    }

    public function update(Request $request, PenjualanSampah $penjualan)
    {
        $request->validate([
            'sampah_id' => 'required|exists:sampahs,id',
            'berat' => 'required|integer|min:1',
            'tanggal_penjualan' => 'required|date',
        ]);

        $sampah = Sampah::findOrFail($request->sampah_id);
        $totalHargaBaru = $request->berat * $sampah->jenisSampah->harga_per_kg;
        $selisih = $totalHargaBaru - $penjualan->total_harga;

        DB::transaction(function () use ($penjualan, $request, $totalHargaBaru, $selisih) {
            $penjualan->update([
                'sampah_id' => $request->sampah_id,
                'berat' => $request->berat,
                'total_harga' => $totalHargaBaru,
                'tanggal_penjualan' => $request->tanggal_penjualan,
            ]);

            $bank = BankSaldo::first();
            if ($bank) {
                $bank->increment('saldo', $selisih);
            }
        });

        $saldoBaru = BankSaldo::first()->saldo ?? 0;

        return redirect()->route('admin.penjualan.index')
            ->with('success', 'Penjualan diperbarui!')
            ->with('saldo_update', $saldoBaru);
    }

    public function destroy(PenjualanSampah $penjualan)
    {
        DB::transaction(function () use ($penjualan) {
            $bank = BankSaldo::first();
            if ($bank && $penjualan->total_harga > 0) {
                $bank->decrement('saldo', $penjualan->total_harga);
            }
            $penjualan->delete();
        });

        $saldoBaru = BankSaldo::first()->saldo ?? 0;

        return response()->json([
            'success' => true,
            'saldo_update' => $saldoBaru
        ]);
    }

    public function exportPdf()
    {
        $penjualan = PenjualanSampah::with('sampah.jenisSampah')->get907();
        $pdf = PDF::loadView('admin.penjualan.pdf', compact('penjualan'));
        return $pdf->download('penjualan_sampah_' . now()->format('Ymd') . '.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new PenjualanExport, 'penjualan_sampah_' . now()->format>('Ymd') . '.xlsx');
    }

    private function getMonthlyChartData()
    {
        $data = PenjualanSampah::selectRaw('MONTH(tanggal_penjualan) as month, YEAR(tanggal_penjualan) as year, SUM(total_harga) as total')
            ->where('tanggal_penjualan', '>=', now()->subMonths(11))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $labels = [];
        $values = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $key = $date->format('Y-m');
            $labels[] = $date->translatedFormat('M Y');

            $record = $data->firstWhere(fn($item) => $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT) === $key);
            $values[] = $record ? (float) $record->total : 0;
        }

        return compact('labels', 'values');
    }
}
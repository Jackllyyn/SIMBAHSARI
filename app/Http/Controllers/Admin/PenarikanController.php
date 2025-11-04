<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nasabah;
use App\Models\Penarikan;
use App\Models\BankSaldo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenarikanController extends Controller
{
    public function index(Request $request)
    {
        $query = Penarikan::with('nasabah');

        // Filter: Search
        if ($search = $request->search) {
            $query->whereHas('nasabah', fn($q) => $q->where('nama', 'like', "%$search%"))
                  ->orWhere('jumlah', 'like', "%$search%");
        }

        // Filter: Nasabah
        if ($nasabah_id = $request->nasabah_id) {
            $query->where('nasabah_id', $nasabah_id);
        }

        // Filter: Tanggal
        if ($dari = $request->dari) {
            $query->whereDate('created_at', '>=', $dari);
        }
        if ($sampai = $request->sampai) {
            $query->whereDate('created_at', '<=', $sampai);
        }

        $penarikans = $query->latest()->paginate(10);
        $nasabahs = Nasabah::orderBy('nama')->get();

        return view('admin.penarikans.index', compact('penarikans', 'nasabahs'));
    }

    public function create()
    {
        $nasabahs = Nasabah::where('saldo', '>', 0)->orderBy('nama')->get();
        $bankSaldo = BankSaldo::first()->saldo ?? 0;

        return view('admin.penarikans.create', compact('nasabahs', 'bankSaldo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nasabah_id' => 'required|exists:nasabahs,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $nasabah = Nasabah::findOrFail($request->nasabah_id);
        $bank = BankSaldo::first();

        if ($request->jumlah > $nasabah->saldo) {
            return back()->withErrors(['jumlah' => 'Saldo nasabah tidak mencukupi.']);
        }

        if (!$bank || $request->jumlah > $bank->saldo) {
            return back()->withErrors(['jumlah' => 'Saldo bank tidak mencukupi. Saat ini: Rp ' . number_format($bank->saldo ?? 0, 0, ',', '.')]);
        }

        DB::transaction(function () use ($request, $nasabah, $bank) {
            $nasabah->decrement('saldo', $request->jumlah);
            $bank->decrement('saldo', $request->jumlah);

            Penarikan::create([
                'nasabah_id' => $request->nasabah_id,
                'jumlah' => $request->jumlah,
            ]);
        });

        return redirect()->route('admin.penarikans.index')
            ->with('success', 'Penarikan berhasil. Saldo bank berkurang.');
    }

    public function destroy(Penarikan $penarikan)
    {
        DB::transaction(function () use ($penarikan) {
            $penarikan->nasabah->increment('saldo', $penarikan->jumlah);
            $bank = BankSaldo::first();
            if ($bank) {
                $bank->increment('saldo', $penarikan->jumlah);
            }
            $penarikan->delete();
        });

        return back()->with('success', 'Penarikan dibatalkan & saldo dikembalikan.');
    }
}
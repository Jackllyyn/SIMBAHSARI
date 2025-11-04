<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nasabah;
use App\Models\Sampah;
use App\Models\SetoranSampah;
use Illuminate\Http\Request;

class SetoranSampahController extends Controller
{
   public function index(Request $request)
{
    $query = SetoranSampah::with(['nasabah', 'sampah.jenisSampah']);

    // Filter: Search
    if ($search = $request->search) {
        $query->where(function ($q) use ($search) {
            $q->whereHas('nasabah', fn($n) => $n->where('nama', 'like', "%$search%"))
              ->orWhereHas('sampah', fn($s) => $s->where('nama', 'like', "%$search%"))
              ->orWhere('tanggal_setor', 'like', "%$search%");
        });
    }

    // Filter: Nasabah
    if ($nasabah_id = $request->nasabah_id) {
        $query->where('nasabah_id', $nasabah_id);
    }

    // Filter: Sampah
    if ($sampah_id = $request->sampah_id) {
        $query->where('sampah_id', $sampah_id);
    }

    // Filter: Tanggal (dari - sampai)
    if ($dari = $request->tanggal_dari) {
        $query->whereDate('tanggal_setor', '>=', $dari);
    }
    if ($sampai = $request->tanggal_sampai) {
        $query->whereDate('tanggal_setor', '<=', $sampai);
    }

    $setoranSampahs = $query->latest()->paginate(10);

    // Data untuk filter dropdown
    $nasabahs = Nasabah::orderBy('nama')->get();
    $sampahs = Sampah::with('jenisSampah')->orderBy('nama')->get();

    return view('admin.setoran_sampah.index', compact('setoranSampahs', 'nasabahs', 'sampahs'));
}

    public function create()
    {
        $nasabahs = Nasabah::all();
        $sampahs = Sampah::with('jenisSampah')->get();
        return view('admin.setoran_sampah.create', compact('nasabahs', 'sampahs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nasabah_id' => 'required|exists:nasabahs,id',
            'sampah_id' => 'required|exists:sampahs,id',
            'berat' => 'required|integer|min:1', // HANYA BILANGAN BULAT
            'tanggal_setor' => 'required|date',
        ]);

        $sampah = Sampah::findOrFail($request->sampah_id);
        $totalHarga = $request->berat * $sampah->jenisSampah->harga_per_kg;

        $setoran = SetoranSampah::create([
            'nasabah_id' => $request->nasabah_id,
            'sampah_id' => $request->sampah_id,
            'berat' => $request->berat,
            'total_harga' => $totalHarga,
            'tanggal_setor' => $request->tanggal_setor,
        ]);

        // Update saldo nasabah
        $nasabah = Nasabah::findOrFail($request->nasabah_id);
        $nasabah->increment('saldo', $totalHarga);

        return redirect()->route('admin.setoran_sampah.index')->with('success', 'Setoran sampah berhasil dicatat.');
    }

    public function edit(SetoranSampah $setoranSampah)
    {
        $nasabahs = Nasabah::all();
        $sampahs = Sampah::with('jenisSampah')->get();
        return view('admin.setoran_sampah.edit', compact('setoranSampah', 'nasabahs', 'sampahs'));
    }

    public function update(Request $request, SetoranSampah $setoranSampah)
    {
        $request->validate([
            'nasabah_id' => 'required|exists:nasabahs,id',
            'sampah_id' => 'required|exists:sampahs,id',
            'berat' => 'required|integer|min:1', // HANYA BILANGAN BULAT
            'tanggal_setor' => 'required|date',
        ]);

        // Kurangi saldo dari setoran lama
        $nasabahLama = Nasabah::findOrFail($setoranSampah->nasabah_id);
        $nasabahLama->decrement('saldo', $setoranSampah->total_harga);

        // Hitung total harga baru
        $sampah = Sampah::findOrFail($request->sampah_id);
        $totalHarga = $request->berat * $sampah->jenisSampah->harga_per_kg;

        // Update setoran
        $setoranSampah->update([
            'nasabah_id' => $request->nasabah_id,
            'sampah_id' => $request->sampah_id,
            'berat' => $request->berat,
            'total_harga' => $totalHarga,
            'tanggal_setor' => $request->tanggal_setor,
        ]);

        // Tambah saldo ke nasabah baru
        $nasabahBaru = Nasabah::findOrFail($request->nasabah_id);
        $nasabahBaru->increment('saldo', $totalHarga);

        return redirect()->route('admin.setoran_sampah.index')->with('success', 'Setoran sampah berhasil diperbarui.');
    }

    public function destroy(SetoranSampah $setoranSampah)
    {
        // Kurangi saldo nasabah
        $nasabah = Nasabah::findOrFail($setoranSampah->nasabah_id);
        $nasabah->decrement('saldo', $setoranSampah->total_harga);

        $setoranSampah->delete();

        return redirect()->route('admin.setoran_sampah.index')->with('success', 'Setoran sampah berhasil dihapus.');
    }
}
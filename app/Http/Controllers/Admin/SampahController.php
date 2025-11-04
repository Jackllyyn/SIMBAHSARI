<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sampah;
use App\Models\JenisSampah;
use Illuminate\Http\Request;

class SampahController extends Controller
{
    public function index()
    {
        $jenisSampahs = JenisSampah::latest()->paginate(8);
        $sampahs = Sampah::with('jenisSampah')->latest()->paginate(10);
        $jenisForSelect = JenisSampah::orderBy('nama')->get();

        return view('admin.sampah.index', compact('jenisSampahs', 'sampahs', 'jenisForSelect'));
    }

    // === JENIS SAMPAH ===
    public function createJenis()
    {
        return view('admin.sampah.create_jenis');
    }

    public function storeJenis(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:jenis_sampahs,nama',
            'harga_per_kg' => 'required|numeric|min:0',
        ]);

        JenisSampah::create($request->all());

        return redirect()->route('admin.sampah.index')
            ->with('success', 'Jenis sampah berhasil ditambahkan.');
    }

    // EDIT JENIS → PAKAI VIEW YANG SAMA
    public function editJenis(JenisSampah $jenisSampah)
    {
        return view('admin.sampah.edit', [
            'jenisSampah' => $jenisSampah,
            'isJenis' => true
        ]);
    }

    public function updateJenis(Request $request, JenisSampah $jenisSampah)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:jenis_sampahs,nama,' . $jenisSampah->id,
            'harga_per_kg' => 'required|numeric|min:0',
        ]);

        $jenisSampah->update($request->all());

        return redirect()->route('admin.sampah.index')
            ->with('success', 'Jenis sampah berhasil diperbarui.');
    }

    public function destroyJenis(JenisSampah $jenisSampah)
    {
        if ($jenisSampah->sampahs()->exists()) {
            return back()->withErrors(['delete' => 'Jenis sampah tidak bisa dihapus karena masih digunakan.']);
        }

        $jenisSampah->delete();

        return back()->with('success', 'Jenis sampah berhasil dihapus.');
    }

    // === SAMPAH ===
    public function create()
    {
        $jenisSampahs = JenisSampah::orderBy('nama')->get();
        return view('admin.sampah.create', compact('jenisSampahs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:sampahs,nama',
            'jenis_sampah_id' => 'required|exists:jenis_sampahs,id',
            'deskripsi' => 'nullable|string',
        ]);

        Sampah::create($request->all());

        return redirect()->route('admin.sampah.index')
            ->with('success', 'Sampah berhasil ditambahkan.');
    }

    // EDIT SAMPAH → PAKAI VIEW YANG SAMA
    public function edit(Sampah $sampah)
    {
        $jenisSampahs = JenisSampah::orderBy('nama')->get();
        return view('admin.sampah.edit', [
            'sampah' => $sampah,
            'jenisSampahs' => $jenisSampahs,
            'isJenis' => false
        ]);
    }

    public function update(Request $request, Sampah $sampah)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:sampahs,nama,' . $sampah->id,
            'jenis_sampah_id' => 'required|exists:jenis_sampahs,id',
            'deskripsi' => 'nullable|string',
        ]);

        $sampah->update($request->all());

        return redirect()->route('admin.sampah.index')
            ->with('success', 'Sampah berhasil diperbarui.');
    }

    public function destroy(Sampah $sampah)
    {
        if ($sampah->setoranSampah()->exists()) {
            return back()->withErrors(['delete' => 'Sampah tidak bisa dihapus karena sudah ada transaksi setoran.']);
        }

        $sampah->delete();

        return back()->with('success', 'Sampah berhasil dihapus.');
    }
}
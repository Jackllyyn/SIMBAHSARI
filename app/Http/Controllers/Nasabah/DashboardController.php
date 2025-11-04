<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cek apakah user adalah nasabah
        if (!$user || !$user->isNasabah()) {
            return redirect()->route('login')
                ->with('error', 'Anda harus login sebagai nasabah untuk mengakses halaman ini.');
        }

        $nasabah = $user->nasabah;

        // Ambil riwayat setoran
        $setoranSampahs = $nasabah->setoranSampahs()
            ->with(['sampah.jenisSampah'])
            ->orderBy('tanggal_setor', 'desc')
            ->limit(10) // Limit 10 terbaru
            ->get();

        // Ambil riwayat penarikan
        $penarikans = $nasabah->penarikans()
            ->orderBy('tanggal', 'desc')
            ->limit(10) // Limit 10 terbaru
            ->get();

        return view('nasabah.dashboard', compact('nasabah', 'setoranSampahs', 'penarikans'));
    }

    // === EDIT PROFIL ===
    public function editProfile()
    {
        $user = Auth::user();
        
        if (!$user || !$user->isNasabah()) {
            return redirect()->route('nasabah.dashboard')
                ->with('error', 'Akses ditolak.');
        }

        return view('nasabah.edit', ['nasabah' => $user->nasabah]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        if (!$user || !$user->isNasabah()) {
            return redirect()->route('nasabah.dashboard')
                ->with('error', 'Akses ditolak.');
        }

        $nasabah = $user->nasabah;

        // Validasi
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:500',
            'no_telepon' => 'nullable|string|max:15|regex:/^([0-9\s\-\+\(\)]*)$/',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'no_telepon.regex' => 'No. telepon harus berupa angka dan tanda baca.',
        ]);

        // Update foto jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($nasabah->foto) {
                Storage::disk('public')->delete($nasabah->foto);
            }
            
            // Upload foto baru
            $fotoPath = $request->file('foto')->store('nasabah/foto', 'public');
            $nasabah->foto = $fotoPath;
        }

        // Update data profil
        $nasabah->nama = $request->nama;
        $nasabah->alamat = $request->alamat;
        $nasabah->no_telepon = $request->no_telepon;
        $nasabah->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    // === GANTI PASSWORD ===
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        
        if (!$user || !$user->isNasabah()) {
            return redirect()->route('nasabah.dashboard')
                ->with('error', 'Akses ditolak.');
        }

        // Validasi password
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ], [
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Cek password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah!']);
        }

        // Update password baru
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password berhasil diganti!');
    }
}
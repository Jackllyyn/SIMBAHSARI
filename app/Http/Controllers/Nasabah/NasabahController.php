<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class NasabahController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        if (!$user || !$user->isNasabah()) {
            return redirect()->route('login')
                ->with('error', 'Anda harus login sebagai nasabah.');
        }

        $nasabah = $user->nasabah;

        $setoranSampahs = $nasabah->setoranSampahs()
            ->with(['sampah.jenisSampah'])
            ->orderBy('tanggal_setor', 'desc')
            ->limit(10)
            ->get();

        $penarikans = $nasabah->penarikans()
            ->orderBy('tanggal', 'desc')
            ->limit(10)
            ->get();

        return view('nasabah.dashboard', compact('nasabah', 'setoranSampahs', 'penarikans'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        if (!$user || !$user->isNasabah()) {
            return redirect()->route('nasabah.dashboard');
        }
        return view('nasabah.edit', ['nasabah' => $user->nasabah]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->isNasabah()) {
            return redirect()->route('nasabah.dashboard');
        }

        $nasabah = $user->nasabah;

        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:500',
            'no_telepon' => 'nullable|string|max:15|regex:/^([0-9\s\-\+\(\)]*)$/',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nama', 'alamat', 'no_telepon']);

        if ($request->hasFile('foto')) {
            if ($nasabah->foto) {
                Storage::disk('public')->delete($nasabah->foto);
            }
            $data['foto'] = $request->file('foto')->store('nasabah/foto', 'public');
        }

        $nasabah->update($data);

        return redirect()->route('nasabah.dashboard')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->isNasabah()) {
            return redirect()->route('nasabah.dashboard');
        }

        $request->validate([
            'current_password' => 'required',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->letters()->mixedCase()->numbers()->symbols(),
            ],
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah!']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        Auth::logout();
        return redirect()->route('login')
            ->with('success', 'Password berhasil diubah. Silakan login kembali.');
    }
}
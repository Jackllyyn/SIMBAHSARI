<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nasabah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class NasabahController extends Controller
{
    public function index()
    {
                $nasabahs = Nasabah::with('user')->paginate(10); // 10 per halaman
        return view('admin.nasabah.index', compact('nasabahs'));
    }

    public function create()
    {
        return view('admin.nasabah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:15',
        ]);

        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'nasabah',
        ]);

        Nasabah::create([
            'user_id' => $user->id,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'saldo' => 0,
        ]);

        return redirect()->route('admin.nasabah.index')->with('success', 'Nasabah berhasil ditambahkan.');
    }

    public function edit(Nasabah $nasabah)
    {
        return view('admin.nasabah.edit', compact('nasabah'));
    }

    public function update(Request $request, Nasabah $nasabah)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users,email,' . $nasabah->user->id,
        ]);

        $nasabah->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
        ]);

        $nasabah->user->update([
            'name' => $request->nama,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.nasabah.index')->with('success', 'Nasabah berhasil diperbarui.');
    }

    public function destroy(Nasabah $nasabah)
    {
        $nasabah->user->delete(); // Deletes user and nasabah (due to onDelete('cascade'))
        return redirect()->route('admin.nasabah.index')->with('success', 'Nasabah berhasil dihapus.');
    }
}
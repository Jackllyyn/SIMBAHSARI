<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();
        $user->loadMissing('nasabah'); // Pastikan relasi ter-load untuk isNasabah()

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard'); // Langsung ke dashboard admin
        }

        if ($user->isNasabah()) {
            return redirect()->route('nasabah.dashboard'); // Langsung ke dashboard nasabah
        }

        return redirect()->route('home'); // Fallback
    }

    public function destroy(\Illuminate\Http\Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
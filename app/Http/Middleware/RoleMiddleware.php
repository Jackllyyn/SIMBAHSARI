<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $user->loadMissing('nasabah'); // Pastikan relasi ter-load

        if ($role === 'admin' && !$user->isAdmin()) {
            return redirect()->route('home')->with('error', 'Akses hanya untuk admin.');
        }

        if ($role === 'nasabah' && !$user->isNasabah()) {
            return redirect()->route('home')->with('error', 'Akses hanya untuk nasabah.');
        }

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // role admin tidak boleh masuk area user (pakai login admin terpisah)
        if ($role === 'user' && method_exists($user, 'hasRole') && $user->hasRole('admin')) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }

        // cek session role bila ada
        if ($request->session()->has('role')) {
            if ($request->session()->get('role') !== $role) {
                return redirect()->route('home')->with('error', 'Akses ditolak.');
            }
        } else {
            // fallback spatie role
            if (method_exists($user, 'hasRole') && !$user->hasRole($role)) {
                return redirect()->route('home')->with('error', 'Akses ditolak.');
            }
        }

        return $next($request);
    }
}
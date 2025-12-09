<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $user = Auth::user();
        
        // Cek role berdasarkan session
        if ($request->session()->has('role')) {
            if ($request->session()->get('role') !== $role) {
                return redirect()->route('home')->with('error', 'Akses ditolak.');
            }
        } 
        // Jika tidak ada session, cek Spatie Role
        elseif (method_exists($user, 'hasRole') && !$user->hasRole($role)) {
            return redirect()->route('home')->with('error', 'Akses ditolak.');
        }
        
        return $next($request);
    }
}
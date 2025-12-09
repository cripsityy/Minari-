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
            return redirect()->route('login');
        }
        
        // Jika pakai session untuk role
        if ($request->session()->has('role')) {
            if ($request->session()->get('role') !== $role) {
                return redirect()->route('landing')->with('error', 'Unauthorized access');
            }
        }
        // Jika pakai Spatie Role/Permission
        else if (!Auth::user()->hasRole($role)) {
            return redirect()->route('landing')->with('error', 'Unauthorized access');
        }
        // Jika pakai field role di database
        else if (Auth::user()->role !== $role) {
            return redirect()->route('landing')->with('error', 'Unauthorized access');
        }
        
        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminGuard
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) {
            Log::warning('Unauthorized access attempt to admin area', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl()
            ]);

            return redirect()->route('admin.access')
                ->with('error', 'Silakan login admin untuk mengakses halaman tersebut.');
        }

        // wajib punya flag rahasia
        if (!$request->session()->has('admin_secret')) {
            Log::error('Admin session missing secret flag', [
                'admin_id' => Auth::guard('admin')->id()
            ]);

            Auth::guard('admin')->logout();
            $request->session()->invalidate();

            return redirect()->route('admin.access')
                ->with('error', 'Sesi admin tidak valid. Silakan login kembali.');
        }

        return $next($request);
    }
}
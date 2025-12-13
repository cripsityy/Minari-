<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
            $credentials = [
                'email' => $request->username,
                'password' => $request->password
            ];
        }

        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();

            // update last login
            if (method_exists($admin, 'update')) {
                $admin->update([
                    'last_login_at' => now(),
                    'last_login_ip' => $request->ip(),
                ]);
            }

            $request->session()->regenerate();

            // ini "kunci" agar admin area valid (dicek AdminGuard)
            session([
                'admin_id' => $admin->id,
                'admin_role' => $admin->is_super_admin ? 'super_admin' : 'admin',
                'admin_name' => $admin->name,
                'role' => 'admin',
                'admin_secret' => true, // ✅ penting
            ]);

            // pastikan user session bersih
            Auth::guard('web')->logout();
            session()->forget(['customer_id', 'user_id']);

            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, Admin!');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput()->with('error', 'Login gagal');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->forget([
            'admin_id', 'admin_role', 'admin_name', 'role', 'admin_secret'
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('info', 'Anda telah logout.');
    }
}
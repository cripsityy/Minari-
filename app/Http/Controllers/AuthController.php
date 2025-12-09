<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // ========== SHOW PAGES ==========
    
    public function showLogin()
    {
        return view('auth.login');
    }
    
    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }
    
    public function showRegister()
    {
        return view('auth.register');
    }
    
    // ========== LOGIN ==========
    
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Coba login dengan username atau email
        $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        $credentials = [
            $loginType => $request->username,
            'password' => $request->password
        ];
        
        // Attempt login
        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'username' => 'Username atau password salah.',
            ])->withInput()->with('error', 'Login gagal');
        }

        // Regenerate session
        $request->session()->regenerate();
        
        // Get authenticated user
        $user = Auth::user();
        
        // Set session role
        if ($user->hasRole('admin')) {
            session(['role' => 'admin']);
            return redirect()->route('admin.dashboard')
                ->with('success', 'Selamat datang, Admin!');
        } else {
            session(['role' => 'user']);
            return redirect()->route('home')
                ->with('success', 'Login berhasil!');
        }
    }
    
    public function adminLogin(Request $request)
    {
        return $this->login($request);
    }
    
    // ========== REGISTER ==========
    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:255',
            'username' => 'required|string|min:3|max:20|unique:users,username|regex:/^[a-zA-Z0-9_.]+$/',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email',
            'birth_date' => 'required|date|before:today',
            'address' => 'required|string|min:5',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'username.regex' => 'Username hanya boleh berisi huruf, angka, underscore (_), dan titik (.)',
            'birth_date.before' => 'Tanggal lahir harus sebelum hari ini',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Silakan perbaiki error di bawah.');
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'birth_date' => $request->birth_date,
                'address' => $request->address,
                'password' => Hash::make($request->password),
            ]);

            // Assign role 'user'
            if (method_exists($user, 'assignRole')) {
                $user->assignRole('user');
            }

            // Auto login setelah register
            Auth::login($user);
            
            // Set session
            $request->session()->regenerate();
            session(['role' => 'user']);
            
            return redirect()->route('home')
                ->with('success', 'Registrasi berhasil! Selamat datang di MINARI!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Registrasi gagal: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    // ========== LOGOUT ==========
    
    public function logout(Request $request)
    {
        // 1. Logout dari Auth Laravel
        Auth::logout();
        
        // 2. Hapus semua session data
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // 3. Clear session manual
        session()->flush();
        
        // 4. Redirect ke home
        return redirect('/')->with('success', 'Logout berhasil!');
    }
    
    // ========== LOGOUT GET (UNTUK NAVBAR JS) ==========
    public function logoutGet()
    {
        return $this->logout(request());
    }
}
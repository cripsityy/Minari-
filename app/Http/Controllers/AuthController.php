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
        // Clear old session data jika ada
        session()->forget('role');
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
        // Validasi input - FIX: username required
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Cari user berdasarkan username ATAU email
        $user = User::where('username', $request->username)
                    ->orWhere('email', $request->username)
                    ->first();

        // Check credentials - FIX: gunakan Auth::attempt
        $credentials = [
            'username' => $user->username ?? $request->username,
            'password' => $request->password
        ];
        
        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'username' => 'Username atau password salah.',
            ])->withInput()->with('error', 'Login gagal');
        }

        // Regenerate session SEBELUM set data
        $request->session()->regenerate();
        
        // Get authenticated user
        $user = Auth::user();
        
        // Set session role
        if ($user->hasRole('admin')) {
            session(['role' => 'admin']);
        } else {
            session(['role' => 'user']);
        }
        
        // Transfer guest cart
        $this->transferGuestCart();
        
        // Redirect berdasarkan role
        if (session('role') === 'admin') {
        return redirect()->route('admin.dashboard')
            ->with('success', 'Selamat datang, Admin!');
        }
        
        // Redirect ke home page
        return redirect()->route('home')
            ->with('success', 'Login berhasil!');
    }
    
    public function adminLogin(Request $request)
    {
        // Sederhanakan: pakai login biasa
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
            // Create user
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
            
            // Redirect
            return redirect()->route('user.dashboard')
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
        // Logout user
        Auth::logout();
        
        // Clear session
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Logout berhasil.');
    }
    
    // ========== HELPER METHODS ==========
    
    private function transferGuestCart()
    {
        if (Auth::check()) {
            $guestCart = session()->get('guest_cart', []);
            
            if (!empty($guestCart)) {
                $user = Auth::user();
                
                foreach ($guestCart as $item) {
                    if (!isset($item['product_id'])) {
                        continue;
                    }
                    
                    // Logic transfer cart
                    // Sesuaikan dengan model Cart kamu
                }
                
                session()->forget('guest_cart');
            }
        }
    }
}
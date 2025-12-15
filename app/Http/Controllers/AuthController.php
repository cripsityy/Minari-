<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLogin()
    {
        // bersihin role (biar gak kebawa)
        session()->forget(['role', 'admin_secret', 'admin_id', 'admin_role', 'admin_name']);
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
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

        $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            $loginType => $request->username,
            'password' => $request->password
        ];

        // 1. COBA LOGIN SEBAGAI USER (Customer)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Opsional: Jika user punya role admin di tabel users (spatie), kick atau biarkan?
            // Sesuai request: "login admin sama user disamain aja",
            // tapi admin 'sebenarnya' ada di tabel admins.
            // Jadi kalau login di tabel users berhasil, anggap user biasa.
            // (Kecuali ada logic khusus untuk block admin-in-users-table)
            
            if (method_exists($user, 'hasRole') && $user->hasRole('admin')) {
                // Konsep lama: admin gak boleh login dari depan?
                // Tapi sekarang disatukan. Kalau dia punya akun user yg role admin,
                // mungkin kita redirect ke dashboard juga?
                // TAPI: Admin 'sejati' ada di tabel admins (guard: admin).
                // Jadi code blok ini mungkin redundant kalau admin-nya beda tabel.
                // Kita biarkan user masuk sebagai user biasa jika ada di tabel users.
            }

            session(['role' => 'user']);
            $this->transferGuestCart();

            return redirect()->route('home')->with('success', 'Login berhasil!');
        }

        // 2. JIKA GAGAL USER, COBA LOGIN SEBAGAI ADMIN (Tabel admins)
        // Kita perlu mapping credentials agar sesuai kolom di tabel admins (biasanya sama)
        // Guard 'admin' biasanya pakai provider 'admins'
        
        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();

            // Update last login (optional, copy dari AdminAuthController)
            if (method_exists($admin, 'update')) {
                $admin->update([
                    'last_login_at' => now(),
                    'last_login_ip' => $request->ip(),
                ]);
            }

            $request->session()->regenerate();

            // Set session khusus admin
            session([
                'admin_id' => $admin->id,
                'admin_role' => $admin->is_super_admin ? 'super_admin' : 'admin',
                'admin_name' => $admin->name,
                'role' => 'admin',
                'admin_secret' => true,
            ]);

            // Pastikan user session bersih (safety)
            Auth::guard('web')->logout();
            session()->forget(['customer_id', 'user_id']);

            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, Admin!');
        }

        // 3. JIKA DUA-DUANYA GAGAL
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput()->with('error', 'Login gagal');
    }

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

            if (method_exists($user, 'assignRole')) {
                $user->assignRole('user');
            }

            Auth::login($user);
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

    public function logout(Request $request)
    {
        Log::info('=== LOGOUT PROCESS START ===');

        $user = Auth::user();
        $userId = $user ? $user->id : null;

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        session()->flush();

        Log::info('Logout berhasil untuk user ID: ' . $userId);
        Log::info('=== LOGOUT PROCESS END ===');

        return redirect('/')->with('success', 'Logout berhasil!');
    }

    public function logoutGet(Request $request)
    {
        return $this->logout($request);
    }

    private function transferGuestCart()
    {
        if (Auth::check()) {
            $guestCart = session()->get('guest_cart', []);
            $user = Auth::user();

            if (!empty($guestCart)) {
                foreach ($guestCart as $item) {
                    $existingItem = $user->carts()->where('product_id', $item['product_id'])
                        ->where('size', $item['size'] ?? '')
                        ->where('color', $item['color'] ?? '')
                        ->first();

                    if ($existingItem) {
                        $existingItem->quantity += $item['quantity'];
                        $existingItem->save();
                    } else {
                        $user->carts()->create([
                            'product_id' => $item['product_id'],
                            'quantity' => $item['quantity'],
                            'size' => $item['size'] ?? '',
                            'color' => $item['color'] ?? '', 
                            // Note: guest cart might have 'price' or 'image' but DB cart relies on product rel
                        ]);
                    }
                }
                session()->forget('guest_cart');
            }
        }
    }
}
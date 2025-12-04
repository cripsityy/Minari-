<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class AuthController extends Controller
{
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
    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        
        if ($request->username === 'user' && $request->password === 'user') {
            $request->session()->regenerate();
            $request->session()->put('role', 'user');
            $request->session()->put('user_id', 1);
            $request->session()->put('username', 'user');
            
            return redirect()->route('user.dashboard');
        }
        
        return back()->withErrors(['username' => 'Invalid credentials.']);
    }
    
    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        
        if ($request->username === 'admin' && $request->password === 'admin') {
            $request->session()->regenerate();
            $request->session()->put('role', 'admin');
            $request->session()->put('user_id', 999);
            $request->session()->put('username', 'admin');
            
            return redirect()->route('admin.dashboard');
        }
        
        return back()->withErrors(['username' => 'Invalid admin credentials.']);
    }
    
    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
        
        $request->session()->regenerate();
        $request->session()->put('role', 'user');
        $request->session()->put('user_id', rand(100, 999));
        $request->session()->put('username', $request->username);
        
        return redirect()->route('user.dashboard');
    }
    
    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('landing');
    }
}
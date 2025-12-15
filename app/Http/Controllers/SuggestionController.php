<?php

namespace App\Http\Controllers;

use App\Models\Suggestion;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    public function store(Request $request)
    {
        // Nama field ini harus match dengan <input name="..."> di landing.blade.php
        // Umumnya: name, email, message
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:150'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        // Auto-fill user data if logged in
        $name = $validated['name'] ?? (\Illuminate\Support\Facades\Auth::check() ? \Illuminate\Support\Facades\Auth::user()->name : null);
        $email = $validated['email'] ?? (\Illuminate\Support\Facades\Auth::check() ? \Illuminate\Support\Facades\Auth::user()->email : null);

        Suggestion::create([
            'name' => $name,
            'email' => $email,
            'message' => $validated['message'],
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'Terima kasih! Saran kamu sudah terkirim.');
    }
}
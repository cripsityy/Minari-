<?php

namespace App\Http\Controllers;

use App\Models\Suggestion;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    public function store(Request $request)
    {
        // Log incoming request
        \Log::info('Suggestion submission started', [
            'all_data' => $request->all(),
            'has_message' => $request->has('message'),
            'message_value' => $request->input('message'),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        try {
            // Nama field ini harus match dengan <input name="..."> di landing.blade.php
            // Umumnya: name, email, message
            $validated = $request->validate([
                'name' => ['nullable', 'string', 'max:100'],
                'email' => ['nullable', 'email', 'max:150'],
                'message' => ['required', 'string', 'max:2000'],
            ]);

            \Log::info('Validation passed', ['validated' => $validated]);

            // Auto-fill user data if logged in, otherwise use submitted data or null
            // Use $request->input() to safely get values that might not exist in the form
            $name = $request->input('name') ?? (\Illuminate\Support\Facades\Auth::check() ? \Illuminate\Support\Facades\Auth::user()->name : null);
            $email = $request->input('email') ?? (\Illuminate\Support\Facades\Auth::check() ? \Illuminate\Support\Facades\Auth::user()->email : null);

            \Log::info('Prepared data for saving', [
                'name' => $name,
                'email' => $email,
                'message' => $validated['message'],
                'ip_address' => $request->ip(),
            ]);

            $suggestion = Suggestion::create([
                'name' => $name,
                'email' => $email,
                'message' => $validated['message'],
                'ip_address' => $request->ip(),
            ]);

            \Log::info('Suggestion saved successfully', [
                'suggestion_id' => $suggestion->id,
                'total_suggestions' => Suggestion::count(),
            ]);

            return back()->with('success', 'Terima kasih! Saran kamu sudah terkirim.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', [
                'errors' => $e->errors(),
                'message' => $e->getMessage(),
            ]);
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Error saving suggestion', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withErrors(['error' => 'Terjadi kesalahan. Silakan coba lagi.']);
        }
    }
}
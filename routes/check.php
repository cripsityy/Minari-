<?php

use Illuminate\Support\Facades\Route;
use App\Models\Suggestion;

Route::get('/check-suggestions', function() {
    $suggestions = Suggestion::latest()->get();
    
    return response()->json([
        'total' => $suggestions->count(),
        'suggestions' => $suggestions->map(function($s) {
            return [
                'id' => $s->id,
                'name' => $s->name,
                'email' => $s->email,
                'message' => $s->message,
                'ip_address' => $s->ip_address,
                'created_at' => $s->created_at->format('Y-m-d H:i:s')
            ];
        })
    ]);
});

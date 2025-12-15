<?php

use Illuminate\Support\Facades\Route;
use App\Models\Suggestion;

Route::post('/test-suggestion', function() {
    try {
        $suggestion = Suggestion::create([
            'name' => null,
            'email' => null,
            'message' => 'Test suggestion from guest - manual test',
            'ip_address' => request()->ip(),
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Suggestion created',
            'data' => $suggestion,
            'total_suggestions' => Suggestion::count()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
});

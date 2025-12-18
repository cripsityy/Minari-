<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Suggestion;

class SuggestionAdminController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = Suggestion::query();

        if ($request->has('search')) {
            $query->where('message', 'like', '%' . $request->search . '%')
                  ->orWhere('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $suggestions = $query->latest()->paginate(20);

        return view('admin.suggestions.index', compact('suggestions'));
    }

    public function destroy(Suggestion $suggestion)
    {
        $suggestion->delete();
        return back()->with('success', 'Suggestion dihapus.');
    }
}
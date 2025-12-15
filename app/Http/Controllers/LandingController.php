<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class LandingController extends Controller
{
    public function index()
    {
        // Redirect admins to dashboard
        if (\Illuminate\Support\Facades\Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        // Fetch featured/popular products for landing page
        $featuredProducts = Product::available()->take(8)->get();
        $categories = Category::withCount('products')->get();
        
        $promotions = \App\Models\Promotion::where('is_active', true)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->get();

        return view('landing', compact('featuredProducts', 'categories', 'promotions'));
    }
    
    public function shirtblouse()
    {
        return view('category.shirtblouse');
    }
    
    public function sweeter()
    {
        return view('category.sweeter');
    }
    
    public function tshirt()
    {
        return view('category.tshirt');
    }
    
    public function pants()
    {
        return view('category.pants');
    }
    
    public function skirt()
    {
        return view('category.skirt');
    }
    
    public function accessories()
    {
        return view('category.accessories');
    }
    
    public function storeSuggestion(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:500'
        ]);
        
        return redirect('/')->with('success', 'Thank you for your suggestion!');
    }
}
<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        return view('landing');
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
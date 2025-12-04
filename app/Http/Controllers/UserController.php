<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
    {
        return view('user.dashboard');
    }
    
    public function account()
    {
        return view('user.account');
    }
    
    public function whislist()
    {
        return view('user.whislist');
    }
    
    public function cart()
    {
        return view('user.cart');
    }
    
    public function search()
    {
        return view('user.search');
    }
    
    public function menu()
    {
        return view('user.menu');
    }
    
    public function orderHistory()
    {
        return view('user.order-history');
    }
    
    public function guestAccount()
    {
        return view('user.account-guest');
    }
}
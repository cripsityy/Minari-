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
        return view('user.akun');
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
        return view('user.menu');
    }
    
    public function menu()
    {
        return view('user.menu');
    }
    
    public function orderHistory()
    {
        return view('user.orderhistory');
    }
    
    public function guestAccount()
    {
        return view('user.akun');
    }
     public function category(Request $request)
    {
        // nanti category.js yang ngatur produk berdasarkan ?cat=
        return view('user.category'); // resources/views/category.blade.php
    }

    public function detailProduk(Request $request)
    {
        // nanti bisa pakai $request->query('product') kalau mau dynamic
        return view('user.detailproduk');
    }
    public function payment() {
        return view('user.detailorder');
    }

    public function paymentMethod() {
        return view('user.paymentmeth');
    }

    public function orderConfirm() {
        return view('user.orderconfirm');
    }

}
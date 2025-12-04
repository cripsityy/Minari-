<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    
    public function account()
    {
        return view('admin.account');
    }
    
    public function products()
    {
        return view('admin.products');
    }
    
    public function categories()
    {
        return view('admin.categories');
    }
    
    public function orders()
    {
        return view('admin.orders');
    }
    
    public function customers()
    {
        return view('admin.customers');
    }
    
    public function reviews()
    {
        return view('admin.reviews');
    }
    
    public function promotions()
    {
        return view('admin.promotions');
    }
    
    public function addProduct()
    {
        return view('admin.add-product');
    }
    
    public function editProduct($id)
    {
        return view('admin.edit-product', ['id' => $id]);
    }
    
    public function addCategory()
    {
        return view('admin.add-category');
    }
    
    public function editCategory($id)
    {
        return view('admin.edit-category', ['id' => $id]);
    }
    
    public function addPromotion()
    {
        return view('admin.add-promotion');
    }
    
    public function orderDetail($id)
    {
        return view('admin.order-detail', ['id' => $id]);
    }
}
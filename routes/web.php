<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

Route::get('/b', [LandingController::class, 'index'])->name('landing');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.post');
Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');

// Akun user login
Route::get('/account', [UserController::class, 'account'])->name('user.akun');

// Wishlist
Route::get('/wishlist', [UserController::class, 'whislist'])->name('user.whislist');

// Cart
Route::get('/cart', [UserController::class, 'cart'])->name('user.cart');

// Search
Route::get('/search', [UserController::class, 'search'])->name('user.search');

// Menu kategori
Route::get('/menu', [UserController::class, 'menu'])->name('user.menu');

// Order history
Route::get('/orders/history', [UserController::class, 'orderHistory'])->name('user.order-history');

Route::get('/logout-clear', function () {
    return view('logout-clear');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/category', [UserController::class, 'category'])->name('category');
Route::get('/detailproduk', [UserController::class, 'detailProduk'])->name('detailproduk');
Route::get('/review', function () {
    return view('user.review');
})->name('user.review');
Route::get('/order-history', function () {
    return view('user.orderhistory');
})->name('order.history');

Route::get('/order-detail', function () {
    return view('user.historydetail');
})->name('order.detail');

Route::get('/payment', [UserController::class, 'payment'])->name('payment.page');
Route::get('/shippingadr', function () {
    return view('user.shippingadr');
})->name('shippingadr');

// PAYMENT METHOD
Route::get('/paymentmeth', function () {
    return view('user.paymentmeth');
})->name('paymentmeth');

Route::get('/order/confirm', [UserController::class, 'orderConfirm'])->name('order.confirm');
Route::get('/rating', function () {
    return view('user.rating');
})->name('rating.page');


Route::prefix('category')->group(function () {
    Route::get('/shirtblouse', [LandingController::class, 'shirtblouse'])->name('category.shirtblouse');
    Route::get('/sweeter', [LandingController::class, 'sweeter'])->name('category.sweeter');
    Route::get('/tshirt', [LandingController::class, 'tshirt'])->name('category.tshirt');
    Route::get('/pants', [LandingController::class, 'pants'])->name('category.pants');
    Route::get('/skirt', [LandingController::class, 'skirt'])->name('category.skirt');
    Route::get('/accessories', [LandingController::class, 'accessories'])->name('category.accessories');
});

Route::post('/suggestion', [LandingController::class, 'storeSuggestion'])->name('suggestion.store');

Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/account', [UserController::class, 'account'])->name('user.account');
    Route::get('/whislist', [UserController::class, 'whislist'])->name('user.whislist');
    Route::get('/cart', [UserController::class, 'cart'])->name('user.cart');
    Route::get('/search', [UserController::class, 'search'])->name('user.search');
    Route::get('/menu', [UserController::class, 'menu'])->name('user.menu');
    Route::get('/order-history', [UserController::class, 'orderHistory'])->name('user.order.history');
    Route::get('/account/guest', [UserController::class, 'guestAccount'])->name('user.account.guest');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/account', [AdminController::class, 'account'])->name('admin.account');
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/customers', [AdminController::class, 'customers'])->name('admin.customers');
    Route::get('/reviews', [AdminController::class, 'reviews'])->name('admin.reviews');
    Route::get('/promotions', [AdminController::class, 'promotions'])->name('admin.promotions');
    
    Route::get('/products/add', [AdminController::class, 'addProduct'])->name('admin.products.add');
    Route::get('/products/edit/{id}', [AdminController::class, 'editProduct'])->name('admin.products.edit');
    Route::get('/categories/add', [AdminController::class, 'addCategory'])->name('admin.categories.add');
    Route::get('/categories/edit/{id}', [AdminController::class, 'editCategory'])->name('admin.categories.edit');
    Route::get('/promotions/add', [AdminController::class, 'addPromotion'])->name('admin.promotions.add');
    Route::get('/orders/detail/{id}', [AdminController::class, 'orderDetail'])->name('admin.orders.detail');
});
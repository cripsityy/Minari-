<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuggestionController; // TAMBAH INI
use App\Http\Middleware\CheckRole;

// Register middleware inline (Laravel 11+)
Route::aliasMiddleware('role', CheckRole::class);

// ========== PUBLIC ROUTES ==========

// Home
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/home', [LandingController::class, 'index'])->name('home');

// ========== LOGOUT ROUTES (SANGAT PENTING) ==========
// Route GET untuk logout dari JavaScript navbar
Route::get('/logout', [AuthController::class, 'logoutGet'])->name('logout.get');

// Route POST untuk logout dari form
Route::post('/logout', [AuthController::class, 'logout'])->name('logout.post');

// ========== AUTHENTICATION ROUTES ==========
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/admin-login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/admin-login', [AuthController::class, 'adminLogin'])->name('admin.login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// ========== SUGGESTIONS ROUTE ==========
// TAMBAHKAN INI SEBELUM AUTHENTICATED ROUTES
Route::post('/suggestions', [SuggestionController::class, 'store'])->name('suggestion.store');

// ========== PUBLIC PAGES ==========
Route::get('/category', [UserController::class, 'category'])->name('category');
Route::get('/products/{slug}', [UserController::class, 'detailProduk'])->name('products.detail');
Route::get('/menu', [UserController::class, 'menu'])->name('user.menu');
Route::get('/cart', [UserController::class, 'cart'])->name('cart');
Route::get('/wishlist', [UserController::class, 'wishlist'])->name('wishlist');

// Guest Cart API
Route::prefix('api/guest-cart')->group(function () {
    Route::post('/add', [UserController::class, 'guestCartAddAPI'])->name('api.guest-cart.add');
    Route::put('/{id}', [UserController::class, 'guestCartUpdateAPI'])->name('api.guest-cart.update');
    Route::delete('/{id}', [UserController::class, 'guestCartRemoveAPI'])->name('api.guest-cart.remove');
});

// Public Wishlist API
Route::get('/api/wishlist', [UserController::class, 'getWishlistAPI'])->name('api.wishlist.get');

// ========== AUTHENTICATED ROUTES ==========
Route::middleware(['auth'])->group(function () {
    
    // ========== USER ROUTES ==========
    Route::middleware([CheckRole::class . ':user'])->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
        Route::get('/account', [UserController::class, 'account'])->name('account');
        Route::get('/order-history', [UserController::class, 'orderHistory'])->name('order.history');
        Route::get('/order-detail/{id}', [UserController::class, 'orderDetail'])->name('order.detail');
        Route::get('/payment', [UserController::class, 'payment'])->name('payment');
        Route::get('/payment-method', [UserController::class, 'paymentMethod'])->name('payment.method');
        Route::get('/order-confirm', [UserController::class, 'orderConfirm'])->name('order.confirm');
        
        // API Actions
        Route::post('/cart/add', [UserController::class, 'addToCart'])->name('cart.add');
        Route::put('/cart/{id}', [UserController::class, 'updateCart'])->name('cart.update');
        Route::delete('/cart/{id}', [UserController::class, 'removeFromCart'])->name('cart.remove');
        Route::post('/wishlist/add', [UserController::class, 'addToWishlist'])->name('wishlist.add');
        Route::delete('/wishlist/{id}', [UserController::class, 'removeFromWishlist'])->name('wishlist.remove');
        Route::post('/review/submit', [UserController::class, 'submitReview'])->name('review.submit');
    });
    
    // ========== SHARED ORDER ROUTES ==========
    Route::get('/orderhistory', [UserController::class, 'orderHistory'])->name('orderhistory');
    Route::get('/orderdetail/{id}', [UserController::class, 'orderDetail'])->name('orderdetail');
    
    // ========== SHARED API ROUTES ==========
    Route::prefix('api/wishlist')->name('api.wishlist.')->group(function () {
        Route::post('/add', [UserController::class, 'addToWishlistAPI'])->name('add');
        Route::delete('/{id}', [UserController::class, 'removeFromWishlistAPI'])->name('remove');
    });
    
    Route::prefix('api/cart')->name('api.cart.')->group(function () {
        Route::post('/add', [UserController::class, 'addToCartAPI'])->name('add');
        Route::put('/{id}', [UserController::class, 'updateCartAPI'])->name('update');
        Route::delete('/{id}', [UserController::class, 'removeFromCartAPI'])->name('remove');
    });
    
    Route::get('/api/user/profile', [UserController::class, 'getUserProfileAPI'])->name('api.user.profile');
});

// ========== ADMIN ROUTES ==========
Route::middleware(['auth', CheckRole::class . ':admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/account', [AdminController::class, 'account'])->name('account');
    
    // Products
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [AdminController::class, 'products'])->name('index');
        Route::get('/add', [AdminController::class, 'addProduct'])->name('add');
        Route::post('/store', [AdminController::class, 'storeProduct'])->name('store');
        Route::get('/edit/{id}', [AdminController::class, 'editProduct'])->name('edit');
        Route::put('/update/{id}', [AdminController::class, 'updateProduct'])->name('update');
        Route::delete('/delete/{id}', [AdminController::class, 'deleteProduct'])->name('delete');
    });
    
    // Categories
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [AdminController::class, 'categories'])->name('index');
        Route::get('/add', [AdminController::class, 'addCategory'])->name('add');
        Route::post('/store', [AdminController::class, 'storeCategory'])->name('store');
        Route::get('/edit/{id}', [AdminController::class, 'editCategory'])->name('edit');
        Route::put('/update/{id}', [AdminController::class, 'updateCategory'])->name('update');
        Route::delete('/delete/{id}', [AdminController::class, 'deleteCategory'])->name('delete');
    });
    
    // Orders
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminController::class, 'orders'])->name('index');
        Route::get('/detail/{id}', [AdminController::class, 'orderDetail'])->name('detail');
        Route::put('/update-status/{id}', [AdminController::class, 'updateOrderStatus'])->name('update-status');
    });
    
    // Customers
    Route::get('/customers', [AdminController::class, 'customers'])->name('customers');
    
    // Reviews
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [AdminController::class, 'reviews'])->name('index');
        Route::put('/update-status/{id}', [AdminController::class, 'updateReviewStatus'])->name('update-status');
    });
    
    // Promotions
    Route::prefix('promotions')->name('promotions.')->group(function () {
        Route::get('/', [AdminController::class, 'promotions'])->name('index');
        Route::get('/add', [AdminController::class, 'addPromotion'])->name('add');
        Route::post('/store', [AdminController::class, 'storePromotion'])->name('store');
        Route::put('/update-status/{id}', [AdminController::class, 'updatePromotionStatus'])->name('update-status');
        Route::delete('/delete/{id}', [AdminController::class, 'deletePromotion'])->name('delete');
    });
});

// ========== FALLBACK ROUTE ==========
Route::fallback(function () {
    return redirect()->route('landing');
});
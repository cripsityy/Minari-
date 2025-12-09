<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\CheckRole;

// Register middleware inline (Laravel 11+)
Route::aliasMiddleware('role', CheckRole::class);

// ========== PUBLIC ROUTES (Tanpa Authentication) ==========

// Landing & Home
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/home', [LandingController::class, 'index'])->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Logout (bisa diakses semua yang sudah login)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Product & Category Routes (Public)
Route::get('/category', [UserController::class, 'category'])->name('category');
Route::get('/products/{slug}', [UserController::class, 'detailProduk'])->name('products.detail');

// Menu Route
Route::get('/menu', [UserController::class, 'menu'])->name('user.menu');

// ========== CART ROUTES (Bisa diakses Guest & User) ==========

// Cart Page (Public)
Route::get('/cart', [UserController::class, 'cart'])->name('cart');

// Guest Cart API (No authentication required)
Route::prefix('api/guest-cart')->group(function () {
    Route::post('/add', [UserController::class, 'guestCartAddAPI'])->name('api.guest-cart.add');
    Route::put('/{id}', [UserController::class, 'guestCartUpdateAPI'])->name('api.guest-cart.update');
    Route::delete('/{id}', [UserController::class, 'guestCartRemoveAPI'])->name('api.guest-cart.remove');
});

// ========== WISHLIST ROUTES (Bisa diakses Guest & User) ==========

// Wishlist Page (Public)
Route::get('/wishlist', [UserController::class, 'wishlist'])->name('wishlist');

// Public Wishlist API (Read-only for guests)
Route::get('/api/wishlist', [UserController::class, 'getWishlistAPI'])->name('api.wishlist.get');

// ========== LEGACY CATEGORY ROUTES (Untuk kompatibilitas) ==========
Route::prefix('category')->group(function () {
    Route::get('/shirt-blouse', [LandingController::class, 'shirtblouse'])->name('category.shirtblouse');
    Route::get('/sweater-cardigan', [LandingController::class, 'sweeter'])->name('category.sweeter');
    Route::get('/t-shirt-polo', [LandingController::class, 'tshirt'])->name('category.tshirt');
    Route::get('/pants', [LandingController::class, 'pants'])->name('category.pants');
    Route::get('/skirt-dress', [LandingController::class, 'skirt'])->name('category.skirt');
    Route::get('/accessories', [LandingController::class, 'accessories'])->name('category.accessories');
});

// Suggestion Route
Route::post('/suggestion', [LandingController::class, 'storeSuggestion'])->name('suggestion.store');

// ========== PUBLIC USER ROUTES (Bisa diakses Guest untuk redirect) ==========
Route::get('/akun', function () {
    // Redirect guest ke login, user ke account page
    if (!auth()->check()) {
        return redirect()->route('login')->with('info', 'Please login to access your account');
    }
    return app()->make(UserController::class)->account();
})->name('akun');

// HAPUS route /orderhistory di sini (pindahkan ke bawah di dalam auth)
// Route::get('/orderhistory', function () { ... }); // <-- HAPUS BARIS INI

// ========== AUTHENTICATED ROUTES ==========
Route::middleware(['auth'])->group(function () {
    
    // ========== USER ROUTES (Hanya untuk role user) ==========
    Route::middleware([CheckRole::class . ':user'])->prefix('user')->name('user.')->group(function () {
        // Dashboard & Account (Alternatif routes)
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
        Route::get('/account', [UserController::class, 'account'])->name('account'); // /user/account
        
        // ORDER ROUTES - Tambahkan di sini
        Route::get('/order-history', [UserController::class, 'orderHistory'])->name('order.history'); // /user/order-history
        Route::get('/order-detail/{id}', [UserController::class, 'orderDetail'])->name('order.detail'); // <-- TAMBAHKAN INI
        
        // Checkout Process
        Route::get('/payment', [UserController::class, 'payment'])->name('payment');
        Route::get('/payment-method', [UserController::class, 'paymentMethod'])->name('payment.method');
        Route::get('/order-confirm', [UserController::class, 'orderConfirm'])->name('order.confirm');
        
        // Legacy API Actions
        Route::post('/cart/add', [UserController::class, 'addToCart'])->name('cart.add');
        Route::put('/cart/{id}', [UserController::class, 'updateCart'])->name('cart.update');
        Route::delete('/cart/{id}', [UserController::class, 'removeFromCart'])->name('cart.remove');
        
        Route::post('/wishlist/add', [UserController::class, 'addToWishlist'])->name('wishlist.add');
        Route::delete('/wishlist/{id}', [UserController::class, 'removeFromWishlist'])->name('wishlist.remove');
        
        // Review Submission
        Route::post('/review/submit', [UserController::class, 'submitReview'])->name('review.submit');
    });
    
    // ========== SHARED ORDER ROUTES (untuk semua user) ==========
    // Tambahkan route orderhistory di sini (bisa diakses dengan /orderhistory)
    Route::get('/orderhistory', [UserController::class, 'orderHistory'])->name('orderhistory');
    Route::get('/orderdetail/{id}', [UserController::class, 'orderDetail'])->name('orderdetail');
    
    // ========== CHECKOUT ROUTES (Hanya user) ==========
    Route::middleware([CheckRole::class . ':user'])->group(function () {
        Route::prefix('cart')->name('cart.')->group(function () {
            Route::get('/checkout', [UserController::class, 'payment'])->name('checkout');
        });
        
        Route::prefix('checkout')->name('checkout.')->group(function () {
            Route::get('/shipping', function () { 
                return view('user.shippingadr'); 
            })->name('shipping');
            
            Route::get('/payment', function () { 
                return view('user.paymentmeth'); 
            })->name('payment');
        });
        
        Route::get('/order/confirm', [UserController::class, 'orderConfirm'])->name('order.confirm');
        Route::get('/rating', function () { return view('user.rating'); })->name('rating.page');
        Route::get('/review', function () { return view('user.review'); })->name('user.review');
    });
    
    // ========== SHARED API ROUTES (User dan Admin bisa akses) ==========
    
    // Wishlist API
    Route::prefix('api/wishlist')->name('api.wishlist.')->group(function () {
        Route::post('/add', [UserController::class, 'addToWishlistAPI'])->name('add');
        Route::delete('/{id}', [UserController::class, 'removeFromWishlistAPI'])->name('remove');
    });
    
    // Cart API
    Route::prefix('api/cart')->name('api.cart.')->group(function () {
        Route::post('/add', [UserController::class, 'addToCartAPI'])->name('add');
        Route::put('/{id}', [UserController::class, 'updateCartAPI'])->name('update');
        Route::delete('/{id}', [UserController::class, 'removeFromCartAPI'])->name('remove');
    });
    
    // User Profile API
    Route::get('/api/user/profile', [UserController::class, 'getUserProfileAPI'])->name('api.user.profile');
});

// ========== ADMIN ROUTES (Hanya untuk role admin) ==========
Route::middleware(['auth', CheckRole::class . ':admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/account', [AdminController::class, 'account'])->name('account');
    
    // Products Management
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [AdminController::class, 'products'])->name('index');
        Route::get('/add', [AdminController::class, 'addProduct'])->name('add');
        Route::post('/store', [AdminController::class, 'storeProduct'])->name('store');
        Route::get('/edit/{id}', [AdminController::class, 'editProduct'])->name('edit');
        Route::put('/update/{id}', [AdminController::class, 'updateProduct'])->name('update');
        Route::delete('/delete/{id}', [AdminController::class, 'deleteProduct'])->name('delete');
    });
    
    // Categories Management
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [AdminController::class, 'categories'])->name('index');
        Route::get('/add', [AdminController::class, 'addCategory'])->name('add');
        Route::post('/store', [AdminController::class, 'storeCategory'])->name('store');
        Route::get('/edit/{id}', [AdminController::class, 'editCategory'])->name('edit');
        Route::put('/update/{id}', [AdminController::class, 'updateCategory'])->name('update');
        Route::delete('/delete/{id}', [AdminController::class, 'deleteCategory'])->name('delete');
    });
    
    // Orders Management
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminController::class, 'orders'])->name('index');
        Route::get('/detail/{id}', [AdminController::class, 'orderDetail'])->name('detail');
        Route::put('/update-status/{id}', [AdminController::class, 'updateOrderStatus'])->name('update-status');
    });
    
    // Customers Management
    Route::get('/customers', [AdminController::class, 'customers'])->name('customers');
    
    // Reviews Management
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [AdminController::class, 'reviews'])->name('index');
        Route::put('/update-status/{id}', [AdminController::class, 'updateReviewStatus'])->name('update-status');
    });
    
    // Promotions Management
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
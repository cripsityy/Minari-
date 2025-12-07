
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

// Public Routes
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/b', [LandingController::class, 'index'])->name('home');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Category Routes - HARUS ADA ROUTE INI
Route::get('/category', [UserController::class, 'category'])->name('category');
Route::get('/menu', [UserController::class, 'menu'])->name('user.menu');
Route::get('/wishlist', [UserController::class, 'whislist'])->name('user.wishlist');

// Category Pages (Legacy - untuk kompatibilitas)
Route::prefix('category')->group(function () {
    Route::get('/shirt-blouse', [LandingController::class, 'shirtblouse'])->name('category.shirtblouse');
    Route::get('/sweater-cardigan', [LandingController::class, 'sweeter'])->name('category.sweeter');
    Route::get('/t-shirt-polo', [LandingController::class, 'tshirt'])->name('category.tshirt');
    Route::get('/pants', [LandingController::class, 'pants'])->name('category.pants');
    Route::get('/skirt-dress', [LandingController::class, 'skirt'])->name('category.skirt');
    Route::get('/accessories', [LandingController::class, 'accessories'])->name('category.accessories');
});

// Store Suggestion
Route::post('/suggestion', [LandingController::class, 'storeSuggestion'])->name('suggestion.store');

// Public Product & Category Routes
Route::get('/products/{slug}', [UserController::class, 'detailProduk'])->name('products.detail');
Route::get('/category/{slug}', [UserController::class, 'category'])->name('category.show');

// Checkout Process Routes
Route::get('/cart/checkout', [UserController::class, 'payment'])->name('checkout');
Route::get('/checkout/shipping', function () { return view('user.shippingadr'); })->name('checkout.shipping');
Route::get('/checkout/payment', function () { return view('user.paymentmeth'); })->name('checkout.payment');
Route::get('/order/confirm', [UserController::class, 'orderConfirm'])->name('order.confirm');
Route::get('/rating', function () { return view('user.rating'); })->name('rating.page');
Route::get('/review', function () { return view('user.review'); })->name('user.review');

// User Routes (Authenticated)
Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/account', [UserController::class, 'account'])->name('user.account');
    Route::get('/wishlist', [UserController::class, 'whislist'])->name('user.wishlist');
    Route::get('/cart', [UserController::class, 'cart'])->name('user.cart');
    Route::get('/menu', [UserController::class, 'menu'])->name('user.menu');
    Route::get('/order-history', [UserController::class, 'orderHistory'])->name('user.order.history');
    
    // API Actions
    Route::post('/cart/add', [UserController::class, 'addToCart'])->name('cart.add');
    Route::put('/cart/{id}', [UserController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/{id}', [UserController::class, 'removeFromCart'])->name('cart.remove');
    
    Route::post('/wishlist/add', [UserController::class, 'addToWishlist'])->name('wishlist.add');
    Route::delete('/wishlist/{id}', [UserController::class, 'removeFromWishlist'])->name('wishlist.remove');
    
    Route::post('/review/submit', [UserController::class, 'submitReview'])->name('review.submit');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/account', [AdminController::class, 'account'])->name('admin.account');
    
    // Products Management
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/products/add', [AdminController::class, 'addProduct'])->name('admin.products.add');
    Route::post('/products/store', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::get('/products/edit/{id}', [AdminController::class, 'editProduct'])->name('admin.products.edit');
    Route::put('/products/update/{id}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/products/delete/{id}', [AdminController::class, 'deleteProduct'])->name('admin.products.delete');
    
    // Categories Management
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/categories/add', [AdminController::class, 'addCategory'])->name('admin.categories.add');
    Route::post('/categories/store', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::get('/categories/edit/{id}', [AdminController::class, 'editCategory'])->name('admin.categories.edit');
    Route::put('/categories/update/{id}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
    Route::delete('/categories/delete/{id}', [AdminController::class, 'deleteCategory'])->name('admin.categories.delete');
    
    // Orders Management
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/orders/detail/{id}', [AdminController::class, 'orderDetail'])->name('admin.orders.detail');
    Route::put('/orders/update-status/{id}', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.update-status');
    
    // Customers Management
    Route::get('/customers', [AdminController::class, 'customers'])->name('admin.customers');
    
    // Reviews Management
    Route::get('/reviews', [AdminController::class, 'reviews'])->name('admin.reviews');
    Route::put('/reviews/update-status/{id}', [AdminController::class, 'updateReviewStatus'])->name('admin.reviews.update-status');
    
    // Promotions Management
    Route::get('/promotions', [AdminController::class, 'promotions'])->name('admin.promotions');
    Route::get('/promotions/add', [AdminController::class, 'addPromotion'])->name('admin.promotions.add');
    Route::post('/promotions/store', [AdminController::class, 'storePromotion'])->name('admin.promotions.store');
    Route::put('/promotions/update-status/{id}', [AdminController::class, 'updatePromotionStatus'])->name('admin.promotions.update-status');
    Route::delete('/promotions/delete/{id}', [AdminController::class, 'deletePromotion'])->name('admin.promotions.delete');
});
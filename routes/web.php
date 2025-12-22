<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\Admin\SuggestionAdminController;

/*
|--------------------------------------------------------------------------
| PUBLIC / LANDING (GUEST DEFAULT)
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| PUBLIC / LANDING (GUEST DEFAULT)
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingController::class, 'index'])->name('home');

Route::get('/test-db', function() {
    try {
        $dbName = \DB::connection()->getDatabaseName();
        $userCount = \DB::table('users')->count();
        // Check for products table if exists, or any other main table
        $tables = \DB::select('SHOW TABLES');
        return response()->json([
            'status' => 'success',
            'database' => $dbName,
            'user_count' => $userCount,
            'tables' => $tables,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
        ]);
    }
});

/*
|--------------------------------------------------------------------------
| CUSTOMER AUTH (DARI IKON USER)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logoutGet'])->name('logout.get');

/*
|--------------------------------------------------------------------------
| CUSTOMER PAGES (GUEST BOLEH AKSES)
|--------------------------------------------------------------------------
*/
Route::get('/wishlist', [UserController::class, 'wishlist'])->name('wishlist');
Route::get('/cart', [UserController::class, 'cart'])->name('cart');
Route::get('/menu', [UserController::class, 'menu'])->name('menu');
Route::get('/search', [UserController::class, 'search'])->name('search');

/*
|--------------------------------------------------------------------------
| CATEGORY (FIX: SUPAYA route('category') & route('user.category') AMAN)
|--------------------------------------------------------------------------
*/
//Route::get('/category', [UserController::class, 'category'])->name('category');
Route::get('/category', [UserController::class, 'category'])->name('user.category');
Route::get('/category-alias', function () {
    return redirect()->route('user.category');
})->name('category');
Route::get('/product/{slug}', [UserController::class, 'detailProduk'])->name('product.detail');

/*
|--------------------------------------------------------------------------
| CUSTOMER (LOGIN REQUIRED)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'checkRole:user'])->group(function () {

    Route::get('/account', [UserController::class, 'account'])->name('user.account');

    // Shipping Address
    Route::get('/shipping-address', [UserController::class, 'shippingAddress'])->name('user.shipping.address');
    Route::post('/shipping-address', [UserController::class, 'storeShippingAddress'])->name('shipping.address.store');

    Route::get('/payment', [UserController::class, 'payment'])->name('payment');
    Route::get('/payment-method', [UserController::class, 'paymentMethod'])->name('payment.method');
    


    Route::post('/place-order', [UserController::class, 'placeOrder'])->name('place.order');
    Route::get('/order-confirm', [UserController::class, 'orderConfirm'])->name('order.confirm');

    Route::get('/order-history', [UserController::class, 'orderHistory'])->name('order.history');
    Route::get('/order/{id}', [UserController::class, 'orderDetail'])->name('order.detail');
    
    Route::get('/rating', [UserController::class, 'ratingPage'])->name('rating.page');
});

/*
|--------------------------------------------------------------------------
| SUGGESTION (FORM DI LANDING PAGE)
|--------------------------------------------------------------------------
| Dipakai oleh: route('suggestion.store')
*/
Route::post('/suggestion', [SuggestionController::class, 'store'])
    ->name('suggestion.store');

// Test route for debugging
Route::get('/test-suggestion', function() {
    try {
        $suggestion = \App\Models\Suggestion::create([
            'name' => null,
            'email' => null,
            'message' => 'Test suggestion from guest - manual test',
            'ip_address' => request()->ip(),
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Suggestion created',
            'data' => $suggestion,
            'total_suggestions' => \App\Models\Suggestion::count()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
});

// Check all suggestions
Route::get('/check-suggestions', function() {
    $suggestions = \App\Models\Suggestion::latest()->get();
    
    return response()->json([
        'total' => $suggestions->count(),
        'suggestions' => $suggestions->map(function($s) {
            return [
                'id' => $s->id,
                'name' => $s->name,
                'email' => $s->email,
                'message' => $s->message,
                'ip_address' => $s->ip_address,
                'created_at' => $s->created_at->format('Y-m-d H:i:s')
            ];
        })
    ]);
});



/*
|--------------------------------------------------------------------------
| API (AJAX) — CART/WISHLIST
|--------------------------------------------------------------------------
*/
Route::prefix('api')->group(function () {

    // Wishlist
    Route::get('/wishlist', [UserController::class, 'getWishlistAPI'])->name('api.wishlist.get');
    Route::post('/wishlist', [UserController::class, 'addToWishlistAPI'])->name('api.wishlist.add');
    Route::delete('/wishlist/{id}', [UserController::class, 'removeFromWishlistAPI'])->name('api.wishlist.remove');

    // Cart login
    Route::post('/cart', [UserController::class, 'addToCartAPI'])->name('api.cart.add');
    Route::patch('/cart/{id}', [UserController::class, 'updateCartAPI'])->name('api.cart.update');
    Route::delete('/cart/{id}', [UserController::class, 'removeFromCartAPI'])->name('api.cart.remove');

    // Cart guest
    Route::post('/guest/cart', [UserController::class, 'guestCartAddAPI'])->name('api.guest.cart.add');
    Route::patch('/guest/cart/{id}', [UserController::class, 'guestCartUpdateAPI'])->name('api.guest.cart.update');
    Route::delete('/guest/cart/{id}', [UserController::class, 'guestCartRemoveAPI'])->name('api.guest.cart.remove');

    // General
    Route::get('/user/counts', [UserController::class, 'getUserCounts'])->name('api.user.counts');

    // Reviews
    Route::post('/submit-review', [UserController::class, 'submitReview'])->name('api.submit.review');
});

/*
|--------------------------------------------------------------------------
| ADMIN — LOGIN RAHASIA
|--------------------------------------------------------------------------
*/
Route::get('/__admin', [AdminAuthController::class, 'showLogin'])->name('admin.access');
Route::post('/__admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::post('/__admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth:admin', 'admin.guard'])
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/account', [AdminController::class, 'account'])->name('admin.account');

        /*
        |-------------------------
        | SUGGESTIONS (ADMIN)
        |-------------------------
        */
        Route::get('/suggestions', [SuggestionAdminController::class, 'index'])
            ->name('admin.suggestions.index');

        Route::delete('/suggestions/{suggestion}', [SuggestionAdminController::class, 'destroy'])
            ->name('admin.suggestions.destroy');

        /*
        |-------------------------
        | PRODUCTS
        |-------------------------
        */
        Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
        Route::get('/products/add', [AdminController::class, 'addProduct'])->name('admin.products.add');
        Route::post('/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
        Route::get('/products/{id}/edit', [AdminController::class, 'editProduct'])->name('admin.products.edit');
        Route::post('/products/{id}', [AdminController::class, 'updateProduct'])->name('admin.products.update');

        Route::delete('/products/{id}', [AdminController::class, 'deleteProduct'])->name('admin.products.delete');

        /*
        |-------------------------
        | CATEGORIES
        |-------------------------
        */
        Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
        Route::get('/categories/add', [AdminController::class, 'addCategory'])->name('admin.categories.add');
        Route::post('/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
        Route::get('/categories/{id}/edit', [AdminController::class, 'editCategory'])->name('admin.categories.edit');
        Route::put('/categories/{id}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
        Route::delete('/categories/{id}', [AdminController::class, 'deleteCategory'])->name('admin.categories.delete');

        /*
        |-------------------------
        | ORDERS
        |-------------------------
        */
        Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
        Route::get('/orders/{id}', [AdminController::class, 'orderDetail'])->name('admin.orders.detail');

        Route::post('/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.status');

        /*
        |-------------------------
        | REVIEWS
        |-------------------------
        */
        Route::get('/reviews', [AdminController::class, 'reviews'])->name('admin.reviews');
        Route::post('/reviews/{id}/status', [AdminController::class, 'updateReviewStatus'])->name('admin.reviews.status');
        /*
        |-------------------------
        | PROMOTIONS
        |-------------------------
        */
        Route::get('/promotions', [AdminController::class, 'promotions'])->name('admin.promotions');
        Route::get('/promotions/add', [AdminController::class, 'addPromotion'])->name('admin.promotions.add');
        Route::post('/promotions', [AdminController::class, 'storePromotion'])->name('admin.promotions.store');
        Route::get('/promotions/{id}/edit', [AdminController::class, 'editPromotion'])->name('admin.promotions.edit');
        Route::put('/promotions/{id}', [AdminController::class, 'updatePromotion'])->name('admin.promotions.update');
        Route::post('/promotions/{id}/status', [AdminController::class, 'updatePromotionStatus'])->name('admin.promotions.status');
        Route::delete('/promotions/{id}', [AdminController::class, 'deletePromotion'])->name('admin.promotions.delete');
    });
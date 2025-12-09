<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        return redirect('/')->with('info', 'Welcome back!');
    }
    
    public function account()
    {
        $user = Auth::user();
        return view('user.akun', compact('user'));
    }
    
    public function wishlist()
    {
        // Jika user tidak login, tampilkan wishlist kosong
        if (!Auth::check()) {
            $wishlists = collect(); // Collection kosong
            return view('user.whislist', compact('wishlists'));
        }
        
        // Jika user login, tampilkan wishlist user
        $wishlists = Auth::user()->wishlists()->with('product')->get();
        return view('user.whislist', compact('wishlists'));
    }
    
    public function cart(Request $request)
    {
        // Jika user tidak login, tampilkan cart dari session
        if (!Auth::check()) {
            // Ambil cart dari session
            $guestCart = session()->get('guest_cart', []);
            
            // Format cart items untuk view - menggunakan nama variabel $cartItems
            $cartItems = collect($guestCart)->map(function($item) {
                return (object)[
                    'id' => $item['id'] ?? uniqid('guest_'),
                    'product_id' => $item['product_id'] ?? ($item['id'] ?? 0),
                    'product' => (object)[
                        'id' => $item['product_id'] ?? ($item['id'] ?? 0),
                        'name' => $item['name'] ?? 'Product',
                        'price' => $item['price'] ?? 0,
                        'final_price' => $item['price'] ?? 0,
                        'image' => $item['image'] ?? '/images/default-product.jpg'
                    ],
                    'quantity' => $item['quantity'] ?? 1,
                    'size' => $item['size'] ?? '',
                    'color' => $item['color'] ?? '',
                    'subtotal' => ($item['price'] ?? 0) * ($item['quantity'] ?? 1)
                ];
            });
            
            $subtotal = $cartItems->sum('subtotal');
            return view('user.cart', compact('cartItems', 'subtotal'));
        }
        
        // Jika user login, tampilkan cart dari database
        $user = Auth::user();
        $cartItems = $user->carts()->with('product')->get();
        
        // Calculate subtotal
        $subtotal = $cartItems->sum(function($item) {
            $price = $item->product->final_price ?? $item->product->price ?? 0;
            return $price * $item->quantity;
        });
        
        return view('user.cart', compact('cartItems', 'subtotal'));
    }

    public function addToCartGuest(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
            'image' => 'nullable|string'
        ]);
        
        // Get current guest cart from session
        $cart = session()->get('guest_cart', []);
        
        // Check if item already exists
        $existingIndex = null;
        foreach ($cart as $index => $item) {
            if ($item['product_id'] == $request->product_id && 
                $item['size'] == $request->size && 
                $item['color'] == $request->color) {
                $existingIndex = $index;
                break;
            }
        }
        
        if ($existingIndex !== null) {
            // Update quantity
            $cart[$existingIndex]['quantity'] += $request->quantity;
        } else {
            // Add new item
            $cart[] = [
                'id' => uniqid('guest_'),
                'product_id' => $request->product_id,
                'name' => $request->name,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'size' => $request->size ?? '',
                'color' => $request->color ?? '',
                'image' => $request->image ?? '/images/default-product.jpg'
            ];
        }
        
        // Save to session
        session()->put('guest_cart', $cart);
        
        return response()->json([
            'success' => true,
            'message' => 'Item added to cart',
            'cart_count' => count($cart)
        ]);
    }

    public function updateCartGuest(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        
        $cart = session()->get('guest_cart', []);
        $found = false;
        
        foreach ($cart as &$item) {
            if ($item['id'] == $id) {
                $item['quantity'] = $request->quantity;
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found in cart'
            ], 404);
        }
        
        session()->put('guest_cart', $cart);
        
        // Calculate new subtotal
        $subtotal = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));
        
        return response()->json([
            'success' => true,
            'subtotal' => $subtotal,
            'formatted_subtotal' => 'Rp ' . number_format($subtotal, 0, ',', '.')
        ]);
    }
    
    public function removeFromCartGuest($id)
    {
        $cart = session()->get('guest_cart', []);
        
        $newCart = array_filter($cart, function($item) use ($id) {
            return $item['id'] != $id;
        });
        
        session()->put('guest_cart', array_values($newCart));
        
        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
            'cart_count' => count($newCart)
        ]);
    }
    
    public function menu()
    {
        return view('user.menu');
    }
    
    public function orderHistory()
    {
        $orders = auth()->user()->orders()->latest()->get();
    
        // Jika belum ada database, buat data dummy
        if ($orders->isEmpty()) {
            $orders = collect([
                (object)[
                    'id' => '0103',
                    'order_number' => '#0103',
                    'date' => '31 Oct 2025',
                    'status' => 'Sent',
                    'items' => [
                        (object)[
                            'product_name' => 'Soft green cardigan',
                            'quantity' => 1,
                            'size' => 'M',
                            'price' => 'Rp. 250.000,00'
                        ]
                    ],
                    'delivery' => 'Home',
                    'payment_method' => 'Cash on Delivery',
                    'total' => 'Rp. 250.000,00'
                ],
                // ... tambahkan order lainnya
            ]);
        }
        
        return view('user.orderhistory', compact('orders'));
    }
    public function orderDetail($id)
{
    $order = auth()->user()->orders()
        ->with(['items.product', 'payment', 'shipping'])
        ->where('id', $id)
        ->firstOrFail();
    
    return view('user.orderdetail', compact('order'));
}
    public function category(Request $request)
    {
        $categorySlug = $request->input('cat', 'shirt-blouse');
        
        // Map old category names to new slugs
        $categoryMap = [
            'shirtblouse' => 'shirt-blouse',
            'sweeter' => 'sweater-cardigan',
            'tshirt' => 't-shirt-polo',
            'pants' => 'pants',
            'skirt' => 'skirt-dress',
            'accessories' => 'accessories'
        ];
        
        // Convert old slug to new slug if needed
        if (isset($categoryMap[$categorySlug])) {
            $categorySlug = $categoryMap[$categorySlug];
        }
        
        $category = Category::where('slug', $categorySlug)->first();
        
        if (!$category) {
            // Fallback to first category
            $category = Category::first();
        }
        
        $products = $category->products()->available()->paginate(12);
        
        return view('user.category', compact('category', 'products'));
    }
    
    public function detailProduk(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->available()
            ->take(4)
            ->get();
        
        $reviews = $product->reviews()->where('status', 'approved')->latest()->paginate(5);
        
        // Increment view count
        $product->increment('view_count');
        
        return view('user.detailproduk', compact('product', 'relatedProducts', 'reviews'));
    }
    
    public function payment()
    {
        $user = Auth::user();
        $cartItems = $user->carts()->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart')->with('error', 'Keranjang belanja kosong');
        }
        
        $subtotal = $cartItems->sum(function($item) {
            return ($item->product->final_price ?? $item->product->price ?? 0) * $item->quantity;
        });
        
        $shippingCost = 15000;
        $total = $subtotal + $shippingCost;
        
        return view('user.detailorder', compact('cartItems', 'subtotal', 'shippingCost', 'total'));
    }
    
    public function paymentMethod()
    {
        return view('user.paymentmeth');
    }
    
    public function orderConfirm()
    {
        $latestOrder = Auth::user()->orders()->latest()->first();
        return view('user.orderconfirm', compact('latestOrder'));
    }
    
    // ========== API METHODS ==========
    
    // Wishlist API Methods
    public function getWishlistAPI()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json([], 200); // Return empty array for guests
        }
        
        $wishlists = Auth::user()->wishlists()->with(['product', 'product.category'])->get();
        return response()->json($wishlists);
    }
    
    public function addToWishlistAPI(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);
        
        $user = Auth::user();
        
        // Check if already in wishlist
        $exists = $user->wishlists()->where('product_id', $request->product_id)->exists();
        
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Produk sudah ada di wishlist'
            ]);
        }
        
        $wishlist = $user->wishlists()->create([
            'product_id' => $request->product_id
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke wishlist',
            'wishlist_count' => $user->wishlists()->count()
        ]);
    }
    
    public function removeFromWishlistAPI($id)
    {
        $wishlistItem = Auth::user()->wishlists()->findOrFail($id);
        $wishlistItem->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Produk dihapus dari wishlist'
        ]);
    }
    
    // Cart API Methods for logged-in users
    public function addToCartAPI(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'nullable|string',
            'color' => 'nullable|string'
        ]);
        
        $user = Auth::user();
        $product = Product::findOrFail($request->product_id);
        
        // Check stock
        if ($product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk tidak mencukupi'
            ], 400);
        }
        
        // Check if item already in cart
        $cartItem = $user->carts()
            ->where('product_id', $request->product_id)
            ->where('size', $request->size)
            ->where('color', $request->color)
            ->first();
        
        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            $cartItem = $user->carts()->create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'size' => $request->size,
                'color' => $request->color
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang',
            'cart_count' => $user->carts()->count()
        ]);
    }
    
    public function updateCartAPI(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        
        $cartItem = Auth::user()->carts()->findOrFail($id);
        $product = $cartItem->product;
        
        if ($product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk tidak mencukupi'
            ], 400);
        }
        
        $cartItem->quantity = $request->quantity;
        $cartItem->save();
        
        // Calculate updated subtotal
        $cartItems = Auth::user()->carts()->with('product')->get();
        $subtotal = $cartItems->sum(function($item) {
            return ($item->product->final_price ?? $item->product->price ?? 0) * $item->quantity;
        });
        
        return response()->json([
            'success' => true,
            'subtotal' => $subtotal,
            'formatted_subtotal' => 'Rp ' . number_format($subtotal, 0, ',', '.')
        ]);
    }
    
    public function removeFromCartAPI($id)
    {
        $cartItem = Auth::user()->carts()->findOrFail($id);
        $cartItem->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Produk dihapus dari keranjang',
            'cart_count' => Auth::user()->carts()->count()
        ]);
    }
    
    // Guest Cart API Methods
    public function guestCartAddAPI(Request $request)
    {
        return $this->addToCartGuest($request);
    }
    
    public function guestCartUpdateAPI(Request $request, $id)
    {
        return $this->updateCartGuest($request, $id);
    }
    
    public function guestCartRemoveAPI($id)
    {
        return $this->removeFromCartGuest($id);
    }
    
    // Existing methods (keep these for backward compatibility)
    public function addToCart(Request $request)
    {
        return $this->addToCartAPI($request);
    }
    
    public function updateCart(Request $request, $id)
    {
        return $this->updateCartAPI($request, $id);
    }
    
    public function removeFromCart($id)
    {
        return $this->removeFromCartAPI($id);
    }
    
    public function addToWishlist(Request $request)
    {
        return $this->addToWishlistAPI($request);
    }
    
    public function removeFromWishlist($id)
    {
        return $this->removeFromWishlistAPI($id);
    }
    
    public function submitReview(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
            'is_anonymous' => 'boolean'
        ]);
        
        // Check if user ordered this product
        $order = Auth::user()->orders()->find($request->order_id);
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki pesanan ini'
            ], 403);
        }
        
        // Check if already reviewed
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->where('order_id', $request->order_id)
            ->first();
        
        if ($existingReview) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memberikan ulasan untuk produk ini'
            ]);
        }
        
        $review = Review::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'order_id' => $request->order_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_anonymous' => $request->is_anonymous ?? false,
            'status' => 'pending' // Admin perlu approve
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Ulasan berhasil dikirim. Menunggu persetujuan admin.'
        ]);
    }

    public function getUserProfileAPI()
{
    $user = Auth::user();
    
    return response()->json([
        'success' => true,
        'user' => [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ?? '-',
            'birth_date' => $user->birth_date ?? '-',
            'address' => $user->address ?? '-',
            'role' => $user->hasRole('admin') ? 'admin' : 'user'
        ]
    ]);
}
}
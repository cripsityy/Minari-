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
        
        // Normalize size and color for consistent comparison
        $requestSize = $request->size ?? '';
        $requestColor = $request->color ?? '';
        
        // Check if item already exists
        $existingIndex = null;
        foreach ($cart as $index => $item) {
            $itemSize = $item['size'] ?? '';
            $itemColor = $item['color'] ?? '';
            
            if ($item['product_id'] == $request->product_id && 
                $itemSize == $requestSize && 
                $itemColor == $requestColor) {
                $existingIndex = $index;
                break;
            }
        }
        
        if ($existingIndex !== null) {
            // Update quantity
            $cart[$existingIndex]['quantity'] += $request->quantity;
        } else {
            // Add new item with normalized size/color
            $cart[] = [
                'id' => uniqid('guest_'),
                'product_id' => $request->product_id,
                'name' => $request->name,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'size' => $requestSize,
                'color' => $requestColor,
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
        $categories = Category::withCount('products')->get();
        return view('user.menu', compact('categories'));
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
    
    return view('user.historydetail', compact('order'));
}
    public function category(Request $request)
    {
        $categorySlug = $request->input('cat', 'shirt-blouse');
        
        \Illuminate\Support\Facades\Log::info('Category Debug', [
            'input_slug' => $categorySlug,
            'request_all' => $request->all()
        ]);
        
        $category = Category::where('slug', $categorySlug)->first();
        
        if (!$category) {
            \Illuminate\Support\Facades\Log::warning('Category Not Found, Fallback', ['slug' => $categorySlug]);
            // Fallback to first category if not found
            $category = Category::first();
        } else {
             \Illuminate\Support\Facades\Log::info('Category Found', ['id' => $category->id, 'name' => $category->name]);
        }
        
        $products = $category->products()->available()->get();
        
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
    
    public function payment(Request $request)
    {
        $user = Auth::user();
        
    // Get selected item IDs from query string
    $itemsParam = $request->query('items', '');
    $selectedIds = explode(',', $itemsParam);
    
    \Illuminate\Support\Facades\Log::info('Payment Debug', [
        'user_id' => $user->id,
        'items_param' => $itemsParam,
        'selected_ids' => $selectedIds
    ]);

    // Filter cart items by selected IDs
    $cartItems = $user->carts()
        ->with('product')
        ->whereIn('id', $selectedIds)
        ->get();

    \Illuminate\Support\Facades\Log::info('Cart Items Found', [
        'count' => $cartItems->count(),
        'items' => $cartItems->toArray()
    ]);
    
    if ($cartItems->isEmpty()) {
        return redirect()->route('cart')->with('error', 'Please select items to checkout.');
    }
        
        $subtotal = $cartItems->sum(function($item) {
            return ($item->product->final_price ?? $item->product->price ?? 0) * $item->quantity;
        });
        
        // Calculate Discount (Best available promotion)
        $discount = 0;
        $activePromotions = \App\Models\Promotion::where('is_active', true)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->get();

        foreach ($activePromotions as $promo) {
            // Check usage limit
            if ($promo->usage_limit !== null && $promo->used_count >= $promo->usage_limit) {
                continue;
            }

            $applicableIds = $promo->applicable_products ?? [];
            $isAll = in_array('all', $applicableIds) || empty($applicableIds);
            
            $promoableAmount = 0;
            
            if ($isAll) {
                $promoableAmount = $subtotal;
            } else {
                $promoableAmount = $cartItems->filter(function($item) use ($applicableIds) {
                    return in_array($item->product_id, $applicableIds);
                })->sum(function($item) {
                    return ($item->product->final_price ?? $item->product->price ?? 0) * $item->quantity;
                });
            }
            
            if ($promoableAmount > 0) {
                 $potentialDiscount = $promo->calculateDiscount($promoableAmount);
                 if ($potentialDiscount > $discount) {
                     $discount = $potentialDiscount;
                 }
            }
        }
        
        $shippingCost = 15000;
        $total = $subtotal + $shippingCost - $discount;
        
        // Get user addresses
        $addresses = $user->addresses;
        
        return view('user.detailorder', compact('cartItems', 'subtotal', 'shippingCost', 'discount', 'total', 'addresses', 'selectedIds'));
    }
    
    public function paymentMethod()
    {
        return view('user.paymentmeth');
    }

    public function shippingAddress()
    {
        $user = Auth::user();
        $addresses = $user->addresses()->latest()->get();
        return view('user.shipping_address', compact('addresses'));
    }

    public function storeShippingAddress(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:50',
            'recipient_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'address_line1' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
        ]);

        $user = Auth::user();
        
        // If this is the first address, make it primary
        $isPrimary = $user->addresses()->count() === 0;

        $user->addresses()->create([
            'title' => $request->title,
            'recipient_name' => $request->recipient_name,
            'phone' => $request->phone,
            'address_line1' => $request->address_line1,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'is_primary' => $isPrimary
        ]);

        // Redirect back to payment or shipping list
        // If "from" param exists, could redirect there
        return redirect()->back()->with('success', 'Address added successfully');
    }
    
    public function placeOrder(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string', // Still required but logic might change to use ID
            'shipping_city' => 'required|string',
            'shipping_postal_code' => 'required|string',
            'payment_method' => 'required|in:cash_on_delivery,bank_transfer,e_wallet',
            'notes' => 'nullable|string',
            'selected_items' => 'required|string' // IDs separated by comma
        ]);

        $user = Auth::user();
        
        // Parse selected IDs
        $selectedIds = explode(',', $request->selected_items);
        
        // Fetch specific items
        $cartItems = $user->carts()
            ->with('product')
            ->whereIn('id', $selectedIds)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'No items selected for checkout.');
        }

        // Calculate totals
        $subtotal = $cartItems->sum(function($item) {
            return ($item->product->final_price ?? $item->product->price ?? 0) * $item->quantity;
        });
        // Calculate Discount logic (replicated for security)
        $discount = 0;
        $activePromotions = \App\Models\Promotion::where('is_active', true)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->get();

        foreach ($activePromotions as $promo) {
            if ($promo->usage_limit !== null && $promo->used_count >= $promo->usage_limit) {
                continue;
            }

            $applicableIds = $promo->applicable_products ?? [];
            $isAll = in_array('all', $applicableIds) || empty($applicableIds);
            
            $promoableAmount = 0;
            
            if ($isAll) {
                $promoableAmount = $subtotal;
            } else {
                $promoableAmount = $cartItems->filter(function($item) use ($applicableIds) {
                    return in_array($item->product_id, $applicableIds);
                })->sum(function($item) {
                    return ($item->product->final_price ?? $item->product->price ?? 0) * $item->quantity;
                });
            }
            
            if ($promoableAmount > 0) {
                 $potentialDiscount = $promo->calculateDiscount($promoableAmount);
                 if ($potentialDiscount > $discount) {
                     $discount = $potentialDiscount;
                     // Ideally we would trigger $promo->increment('used_count'); here if we want to track usage
                 }
            }
        }

        $shippingCost = 15000; // Fixed shipping cost
        $tax = 0; // No tax for now
        $total = $subtotal + $shippingCost + $tax - $discount;

        // Create order
        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'user_id' => $user->id,
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => $user->phone, // Or from address
            'shipping_address' => $request->shipping_address, // This might be full string from selected address
            'shipping_city' => $request->shipping_city,
            'shipping_postal_code' => $request->shipping_postal_code,
            'notes' => $request->notes,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'shipping_cost' => $shippingCost,
            'tax' => $tax,
            'total' => max(0, $total),
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
            'order_status' => 'pending'
        ]);

        // Create order items
        foreach ($cartItems as $cartItem) {
            $price = $cartItem->product->final_price ?? $cartItem->product->price ?? 0;

            $order->items()->create([
                'product_id' => $cartItem->product_id,
                'product_name' => $cartItem->product->name, // Required column
                'quantity' => $cartItem->quantity,
                'price' => $price,
                'subtotal' => $price * $cartItem->quantity, // Required column (price * qty)
                'size' => $cartItem->size,
                'color' => $cartItem->color
            ]);

            // Decrease product stock
            // Decrease product stock and check status
            $product = $cartItem->product;
            $newStock = $product->stock - $cartItem->quantity;
            $product->stock = max(0, $newStock);
            
            if ($product->stock <= 0) {
                $product->status = 'inactive';
            }
            $product->save();
            
            // Delete this specific item from cart
            $cartItem->delete();
        }

        return redirect()->route('order.confirm')->with('success', 'Pesanan berhasil dibuat');
    }

    public function orderConfirm()
    {
        $latestOrder = Auth::user()->orders()->latest()->first();
        return view('user.orderconfirm', compact('latestOrder'));
    }

    public function ratingPage(Request $request)
    {
        $orderId = $request->query('order_id');
        $order = null;

        if ($orderId) {
            $order = Auth::user()->orders()->with('items.product')->find($orderId);
        }
        
        // If no specific order, maybe show a list of unreviewed items? 
        // For now, if no order, just return view (it might be empty or handle it)
        
        return view('user.rating', compact('order'));
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
        
        // Normalize size and color to empty string if null
        $size = $request->size ?? '';
        $color = $request->color ?? '';
        
        // Check if item already in cart (handle both null and empty string)
        $cartItem = $user->carts()
            ->where('product_id', $request->product_id)
            ->where(function($query) use ($size) {
                if ($size === '') {
                    $query->whereNull('size')->orWhere('size', '');
                } else {
                    $query->where('size', $size);
                }
            })
            ->where(function($query) use ($color) {
                if ($color === '') {
                    $query->whereNull('color')->orWhere('color', '');
                } else {
                    $query->where('color', $color);
                }
            })
            ->first();
        
        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            $cartItem = $user->carts()->create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'size' => $size ?: null,
                'color' => $color ?: null
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
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_anonymous' => $request->is_anonymous ?? false,
            'status' => 'approved' // Auto-approve for immediate display
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Ulasan berhasil dikirim!'
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
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use App\Models\Review;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }
    
    public function dashboard()
    {
        $stats = [
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'total_products' => Product::count(),
            'total_customers' => User::whereHas('roles', function($q) {
                $q->where('name', 'user');
            })->count(),
            'pending_orders' => Order::where('order_status', 'pending')->count(),
            'pending_reviews' => Review::where('status', 'pending')->count()
        ];
        
        $recentOrders = Order::with('user')->latest()->take(10)->get();
        $topProducts = Product::orderBy('sold_count', 'desc')->take(5)->get();
        
        return view('admin.dashboard', compact('stats', 'recentOrders', 'topProducts'));
    }
    
    public function account()
    {
        $admin = Auth::user();
        return view('admin.account', compact('admin'));
    }
    
    // Products Management
    public function products(Request $request)
    {
        $query = Product::with('category');
        
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
        }
        
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        $products = $query->paginate(15);
        $categories = Category::all();
        
        return view('admin.products', compact('products', 'categories'));
    }
    
    public function addProduct()
    {
        $categories = Category::all();
        return view('admin.add-product', compact('categories'));
    }
    
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $product = new Product();
        $product->name = $request->name;
        $product->slug = \Str::slug($request->name);
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->stock = $request->stock;
        $product->description = $request->description;
        $product->size = $request->size;
        $product->color = $request->color;
        $product->material = $request->material;
        $product->status = $request->status;
        
        // Upload main image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }
        
        // Upload multiple images
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('products/gallery', 'public');
                $images[] = $path;
            }
            $product->images = $images;
        }
        
        $product->save();
        
        return redirect()->route('admin.products')->with('success', 'Produk berhasil ditambahkan');
    }
    
    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        
        return view('admin.edit-product', compact('product', 'categories'));
    }
    
    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $product->name = $request->name;
        $product->slug = \Str::slug($request->name);
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->stock = $request->stock;
        $product->description = $request->description;
        $product->size = $request->size;
        $product->color = $request->color;
        $product->material = $request->material;
        $product->status = $request->status;
        
        // Update main image
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }
        
        // Update multiple images
        if ($request->hasFile('images')) {
            // Delete old images
            if ($product->images) {
                foreach ($product->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('products/gallery', 'public');
                $images[] = $path;
            }
            $product->images = $images;
        }
        
        $product->save();
        
        return redirect()->route('admin.products')->with('success', 'Produk berhasil diperbarui');
    }
    
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        
        // Delete images
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        if ($product->images) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        
        $product->delete();
        
        return redirect()->route('admin.products')->with('success', 'Produk berhasil dihapus');
    }
    
    // Categories Management
    public function categories()
    {
        $categories = Category::withCount('products')->paginate(15);
        return view('admin.categories', compact('categories'));
    }
    
    public function addCategory()
    {
        return view('admin.add-category');
    }
    
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $category = new Category();
        $category->name = $request->name;
        $category->slug = \Str::slug($request->name);
        $category->description = $request->description;
        $category->status = $request->status;
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $category->image = $imagePath;
        }
        
        $category->save();
        
        return redirect()->route('admin.categories')->with('success', 'Kategori berhasil ditambahkan');
    }
    
    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.edit-category', compact('category'));
    }
    
    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $category->name = $request->name;
        $category->slug = \Str::slug($request->name);
        $category->description = $request->description;
        $category->status = $request->status;
        
        if ($request->hasFile('image')) {
            // Delete old image
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            
            $imagePath = $request->file('image')->store('categories', 'public');
            $category->image = $imagePath;
        }
        
        $category->save();
        
        return redirect()->route('admin.categories')->with('success', 'Kategori berhasil diperbarui');
    }
    
    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        
        // Check if category has products
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories')->with('error', 'Tidak dapat menghapus kategori yang memiliki produk');
        }
        
        // Delete image
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        
        $category->delete();
        
        return redirect()->route('admin.categories')->with('success', 'Kategori berhasil dihapus');
    }
    
    // Orders Management
    public function orders(Request $request)
    {
        $query = Order::with('user');
        
        if ($request->has('search')) {
            $query->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_name', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_email', 'like', '%' . $request->search . '%');
        }
        
        if ($request->has('status')) {
            $query->where('order_status', $request->status);
        }
        
        if ($request->has('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }
        
        $orders = $query->latest()->paginate(20);
        
        return view('admin.orders', compact('orders'));
    }
    
    public function orderDetail($id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);
        return view('admin.order-detail', compact('order'));
    }
    
    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'order_status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'tracking_number' => 'nullable|string'
        ]);
        
        $order->order_status = $request->order_status;
        
        if ($request->order_status == 'shipped' && $request->tracking_number) {
            $order->tracking_number = $request->tracking_number;
            $order->shipped_at = now();
        }
        
        if ($request->order_status == 'delivered') {
            $order->delivered_at = now();
        }
        
        $order->save();
        
        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui');
    }
    
    // Customers Management
    public function customers(Request $request)
    {
        $query = User::whereHas('roles', function($q) {
            $q->where('name', 'user');
        });
        
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }
        
        $customers = $query->withCount('orders')->latest()->paginate(20);
        
        return view('admin.customers', compact('customers'));
    }
    
    // Reviews Management
    public function reviews(Request $request)
    {
        $query = Review::with(['user', 'product']);
        
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        $reviews = $query->latest()->paginate(20);
        
        return view('admin.reviews', compact('reviews'));
    }
    
    public function updateReviewStatus(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);
        
        $review->status = $request->status;
        $review->save();
        
        return redirect()->back()->with('success', 'Status ulasan berhasil diperbarui');
    }
    
    // Promotions Management
    public function promotions()
    {
        $promotions = Promotion::latest()->paginate(15);
        return view('admin.promotions', compact('promotions'));
    }
    
    public function addPromotion()
    {
        $categories = Category::all();
        $products = Product::all();
        
        return view('admin.add-promotion', compact('categories', 'products'));
    }
    
    public function storePromotion(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:promotions,code',
            'name' => 'required|string|max:255',
            'type' => 'required|in:percentage,fixed,free_shipping',
            'value' => 'required_if:type,percentage,fixed|nullable|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'
        ]);
        
        $promotion = new Promotion();
        $promotion->code = strtoupper($request->code);
        $promotion->name = $request->name;
        $promotion->description = $request->description;
        $promotion->type = $request->type;
        $promotion->value = $request->value;
        $promotion->min_purchase = $request->min_purchase;
        $promotion->usage_limit = $request->usage_limit;
        $promotion->start_date = $request->start_date;
        $promotion->end_date = $request->end_date;
        $promotion->is_active = $request->has('is_active');
        
        // Set applicable categories/products
        if ($request->has('applicable_to') && $request->applicable_to == 'selected') {
            $promotion->applicable_categories = $request->applicable_categories;
            $promotion->applicable_products = $request->applicable_products;
        }
        
        $promotion->save();
        
        return redirect()->route('admin.promotions')->with('success', 'Promosi berhasil ditambahkan');
    }
    
    public function updatePromotionStatus(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->is_active = $request->has('is_active');
        $promotion->save();
        
        return redirect()->back()->with('success', 'Status promosi berhasil diperbarui');
    }
    
    public function deletePromotion($id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->delete();
        
        return redirect()->route('admin.promotions')->with('success', 'Promosi berhasil dihapus');
    }
}
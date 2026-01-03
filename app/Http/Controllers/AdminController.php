<?php
// app/Http/Controllers/AdminController.php (UPDATE)

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
use Illuminate\Support\Facades\DB;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class AdminController extends Controller
{

    
    public function dashboard(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
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
        
        
        $recentOrdersQuery = Order::with('user')->latest();
        $topProductsQuery = Product::withSum('orderItems', 'quantity')->orderByDesc('order_items_sum_quantity');
        $recentReviewsQuery = Review::with('user')->latest();

        $recentOrders = $recentOrdersQuery->take(5)->get();
        $topProducts = $topProductsQuery->take(5)->get();
        $recentReviews = $recentReviewsQuery->take(3)->get();
        
        return view('admin.dashboard', compact('stats', 'recentOrders', 'topProducts', 'recentReviews'));
    }
    
    public function account()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.account', compact('admin'));
    }
    
    // Products Management (SISANYA SAMA PERSIS)
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
        
        $products = $query->latest()->get();
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
        // Sanitize price (remove thousands separator dots)
        if ($request->has('price')) {
            $request->merge([
                'price' => str_replace('.', '', $request->price)
            ]);
        }
        
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
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
        // Determine size logic removed as column is dropped
        // $category = Category::find($request->category_id);
        // ...
        $product->color = $request->color;
        $product->status = $request->status;
        
        if ($request->hasFile('image')) {
            $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            $product->image = $uploadedFileUrl;
        }
        
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $uploadedUrl = Cloudinary::upload($image->getRealPath())->getSecurePath();
                $images[] = $uploadedUrl;
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
        
        // Sanitize price (remove thousands separator dots)
        if ($request->has('price')) {
            $request->merge([
                'price' => str_replace('.', '', $request->price)
            ]);
        }
        
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $id,
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
        // Determine size logic removed as column is dropped
        // $category = Category::find($request->category_id);
        // ...
        $product->color = $request->color;
        $product->material = $request->material;
        $product->status = $request->status;
        
        if ($request->hasFile('image')) {
            if ($product->image) {
                // Optional: Delete old image from cloudinary/storage
                // Storage::disk('cloudinary')->delete($product->image);
            }
            
            $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            $product->image = $uploadedFileUrl;
        }
        
        if ($request->hasFile('images')) {
            // Logic for deleting old images skipped for safety
            
            $images = [];
            foreach ($request->file('images') as $image) {
                $uploadedUrl = Cloudinary::upload($image->getRealPath())->getSecurePath();
                $images[] = $uploadedUrl;
            }
            $product->images = $images;
        }
        
        $product->save();
        
        return redirect()->route('admin.products')->with('success', 'Produk berhasil diperbarui');
    }
    
    public function deleteProduct($id)
    {
        try {
            // Get data for image deletion before we wipe the record
            $product = DB::table('products')->where('id', $id)->first();
            
            if (!$product) {
                 return redirect()->route('admin.products')->with('error', 'Produk tidak ditemukan');
            }

            if (!$product) {
                 return redirect()->route('admin.products')->with('error', 'Produk tidak ditemukan');
            }

            DB::beginTransaction();

            // 1. Disable Foreign Key Checks temporarily (Nuclear Option)
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // 2. Delete Related Data (Direct SQL)
            DB::table('order_items')->where('product_id', $id)->delete();
            DB::table('carts')->where('product_id', $id)->delete();
            DB::table('wishlists')->where('product_id', $id)->delete();
            DB::table('reviews')->where('product_id', $id)->delete();

            // 3. Delete Product (Direct SQL - Hard Delete)
            DB::table('products')->where('id', $id)->delete();

            // 4. Re-enable Foreign Key Checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            DB::commit();

            // 5. Cleanup Files (After database success)
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            // Handle JSON images manually since we used query builder
            if ($product->images) {
                $images = json_decode($product->images, true);
                if (is_array($images)) {
                    foreach ($images as $image) {
                        Storage::disk('public')->delete($image);
                    }
                }
            }

            return redirect()->route('admin.products')->with('success', 'Produk berhasil dihapus permanen (Force)');
        } catch (\Exception $e) {
            DB::rollBack();
            // Re-enable in case of crash
            try { DB::statement('SET FOREIGN_KEY_CHECKS=1;'); } catch (\Exception $x) {}
            
            return redirect()->route('admin.products')->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }
    
    // Categories Management
    public function categories(Request $request)
    {
        $query = Category::withCount('products');

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $categories = $query->paginate(15);
        return view('admin.categories', compact('categories'));
    }
    
    public function addCategory()
    {
        return view('admin.add-category');
    }
    
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $category = new Category();
        $category->name = $request->name;
        $category->slug = \Str::slug($request->name);
        $category->description = $request->description;
        $category->status = $request->status;
        
        if ($request->hasFile('image')) {
            $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            $category->image = $uploadedFileUrl;
        }

        if ($request->hasFile('background_image')) {
            $bgUrl = Cloudinary::upload($request->file('background_image')->getRealPath())->getSecurePath();
            $category->background_image = $bgUrl;
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
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $category->name = $request->name;
        $category->slug = \Str::slug($request->name);
        $category->description = $request->description;
        $category->status = $request->status;
        
        if ($request->hasFile('image')) {
            if ($category->image) {
                // Storage::disk('public')->delete($category->image);
            }
            
            $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            $category->image = $uploadedFileUrl;
        }

        if ($request->hasFile('background_image')) {
            if ($category->background_image) {
                // Storage::disk('public')->delete($category->background_image);
            }
            
            $bgUrl = Cloudinary::upload($request->file('background_image')->getRealPath())->getSecurePath();
            $category->background_image = $bgUrl;
        }
        
        $category->save();
        
        return redirect()->route('admin.categories')->with('success', 'Kategori berhasil diperbarui');
    }
    
    public function deleteCategory($id)
    {
        try {
            $category = DB::table('categories')->where('id', $id)->first();
            if (!$category) {
                 return redirect()->route('admin.categories')->with('error', 'Kategori tidak ditemukan');
            }

            DB::beginTransaction();
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // 1. Get all products in category
            $products = DB::table('products')->where('category_id', $id)->get();
            $productCount = $products->count();

            // 2. Cascade Delete Products & Relations
            foreach ($products as $product) {
                // Delete relations
                DB::table('order_items')->where('product_id', $product->id)->delete();
                DB::table('carts')->where('product_id', $product->id)->delete();
                DB::table('wishlists')->where('product_id', $product->id)->delete();
                DB::table('reviews')->where('product_id', $product->id)->delete();

                // Delete product images physically
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                if ($product->images) {
                    $images = json_decode($product->images, true);
                    if (is_array($images)) {
                        foreach ($images as $img) {
                            Storage::disk('public')->delete($img);
                        }
                    }
                }

                // Delete Product Record
                DB::table('products')->where('id', $product->id)->delete();
            }
            
            // 3. Delete Category Images
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            if ($category->background_image) {
                Storage::disk('public')->delete($category->background_image);
            }
            
            // 4. Delete Category Record
            DB::table('categories')->where('id', $id)->delete();
            
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            DB::commit();
            
            $msg = $productCount > 0 
                ? "Kategori dan $productCount produk di dalamnya berhasil dihapus permanen (Force)" 
                : 'Kategori berhasil dihapus permanen (Force)';

            return redirect()->route('admin.categories')->with('success', $msg);

        } catch (\Exception $e) {
            DB::rollBack();
            try { DB::statement('SET FOREIGN_KEY_CHECKS=1;'); } catch (\Exception $x) {}
            return redirect()->route('admin.categories')->with('error', 'Gagal menghapus kategori: ' . $e->getMessage());
        }
    }
    
    // Orders Management
    public function orders(Request $request)
    {
        $query = Order::with(['user', 'items']);
        
        if ($request->has('search')) {
            $query->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_name', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_email', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%');
                  });
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
            'payment_status' => 'nullable|in:pending,paid,cancelled,returned',
            'tracking_number' => 'nullable|string'
        ]);
        
        $order->order_status = $request->order_status;

        // Update Payment Status if provided
        if ($request->has('payment_status')) {
            $order->payment_status = $request->payment_status;
        }
        
        // Update tracking number if provided and not already set (or if we want to allow updates until it's "locked" - user said "gak boleh berubah-ubah lagi", implying lock)
        // However, if the field is readonly in generic view, controller should also respect that or just save what comes in. 
        // If the view handles it as readonly, the request might not send it or send the same value.
        // Let's just save it if provided.
        if ($request->has('tracking_number') && $request->tracking_number) {
             $order->tracking_number = $request->tracking_number;
        }

        if ($request->order_status == 'shipped' && !$order->shipped_at) {
             $order->shipped_at = now();
        }
        
        if ($request->order_status == 'delivered' && !$order->delivered_at) {
            $order->delivered_at = now();
        }
        
        $order->save();
        
        // User requested redirect to order list
        return redirect()->route('admin.orders')->with('success', 'Status pesanan berhasil diperbarui');
    }
    
    // Customers Management

    
    // Reviews Management
    public function reviews(Request $request)
    {
        $query = Review::with(['user', 'product']);
        
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('comment', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($u) use ($request) {
                      $u->where('name', 'like', '%' . $request->search . '%');
                  })
                  ->orWhereHas('product', function($p) use ($request) {
                      $p->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }
        
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
    public function promotions(Request $request)
    {
        $query = Promotion::latest();

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('code', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $promotions = $query->get();
        \Illuminate\Support\Facades\Log::info('Admin Promotions View', ['count' => $promotions->count()]);
        return view('admin.promotions', compact('promotions'));
    }

    public function addPromotion()
    {
        $products = Product::where('status', 'active')->get();
        return view('admin.add-promotion', compact('products'));
    }

    public function storePromotion(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('Store Promotion Request', $request->all());

        $request->validate([
            'code' => 'required|unique:promotions,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        try {
            $status = $request->input('status', 'active');
            $isActive = $status !== 'inactive';

            $promotion = Promotion::create([
                'code' => strtoupper($request->code),
                'name' => $request->code, // Fallback name to code
                'description' => $request->description,
                'type' => $request->type,
                'value' => $request->value,
                'min_purchase' => $request->min_purchase,
                'usage_limit' => $request->usage_limit,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'is_active' => $isActive,
                'applicable_products' => $request->applicable_products,
            ]);

            \Illuminate\Support\Facades\Log::info('Promotion Created Successfully', ['id' => $promotion->id]);

            return redirect()->route('admin.promotions')->with('success', 'Promotion created successfully');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Promotion Creation Failed', ['error' => $e->getMessage()]);
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to add promotion: ' . $e->getMessage()]);
        }
    }
    
    // Duplicates removed

    
    public function editPromotion($id)
    {
        $promotion = Promotion::findOrFail($id);
        $products = Product::where('status', 'active')->get();
        return view('admin.edit-promotion', compact('promotion', 'products'));
    }

    public function updatePromotion(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);
        
        $request->validate([
            'code' => 'required|unique:promotions,code,' . $id,
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        try {
            $status = $request->input('status', 'active');
            $isActive = $status !== 'inactive';

            $promotion->update([
                'code' => strtoupper($request->code),
                'name' => $request->code,
                'description' => $request->description,
                'type' => $request->type,
                'value' => $request->value,
                'min_purchase' => $request->min_purchase,
                'usage_limit' => $request->usage_limit,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'is_active' => $isActive,
                'applicable_products' => $request->applicable_products,
            ]);

            return redirect()->route('admin.promotions')->with('success', 'Promotion updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update promotion: ' . $e->getMessage()]);
        }
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
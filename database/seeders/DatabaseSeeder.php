<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cached permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        // ======================
        // 1. CREATE ROLES & PERMISSIONS
        // ======================
        $this->command->info('Creating roles and permissions...');
        
        // Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);
        
        // Create Permissions
        $permissions = [
            'view dashboard',
            'manage products',
            'manage categories',
            'manage orders',
            'manage users',
            'manage reviews',
            'manage promotions',
            'view reports',
            'view products',
            'place orders',
            'write reviews',
            'manage wishlist'
        ];
        
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        
        // Assign permissions to roles
        $adminRole->syncPermissions(Permission::all());
        $userRole->syncPermissions(['view products', 'place orders', 'write reviews', 'manage wishlist']);
        
        $this->command->info('✅ Roles and permissions created!');
        
        // ======================
        // 2. CREATE USERS
        // ======================
        $this->command->info('Creating users...');
        
        // Create Admin
        $admin = User::create([
            'name' => 'Admin MINARI',
            'username' => 'admin',
            'email' => 'admin@minari.com',
            'phone' => '081234567890',
            'birth_date' => '1990-01-01',
            'address' => 'MINARI Headquarters',
            'email_verified_at' => now(),
            'password' => bcrypt('admin123'),
            'remember_token' => Str::random(10),
        ]);
        $admin->assignRole('admin');
        
        // Create Regular User
        $user = User::create([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'user@minari.com',
            'phone' => '08111222333',
            'birth_date' => '1995-05-15',
            'address' => 'Jl. Contoh No. 123, Jakarta',
            'email_verified_at' => now(),
            'password' => bcrypt('password123'),
            'remember_token' => Str::random(10),
        ]);
        $user->assignRole('user');
        
        // Create more sample users
        $sampleUsers = [
            [
                'name' => 'Aliyah Rahma',
                'username' => 'aliyah',
                'email' => 'aliyah@minari.com',
                'phone' => '08123456789',
                'birth_date' => '1998-08-20',
                'address' => 'Jl. Mawar No. 10, Bandung',
                'password' => bcrypt('password123'),
            ],
            [
                'name' => 'Budi Santoso',
                'username' => 'budi',
                'email' => 'budi@minari.com',
                'phone' => '08234567890',
                'birth_date' => '1992-03-12',
                'address' => 'Jl. Melati No. 5, Surabaya',
                'password' => bcrypt('password123'),
            ],
        ];
        
        foreach ($sampleUsers as $userData) {
            $newUser = User::create(array_merge($userData, [
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]));
            $newUser->assignRole('user');
        }
        
        $this->command->info('✅ Users created!');
        
        // ======================
        // 3. CREATE CATEGORIES
        // ======================
        $this->command->info('Creating categories...');
        
        $categories = [
            [
                'name' => 'Shirt & Blouse',
                'slug' => 'shirt-blouse',
                'description' => 'Koleksi kemeja dan blus wanita terbaru',
                'status' => 'active',
                'image' => null
            ],
            [
                'name' => 'Sweater & Cardigan',
                'slug' => 'sweater-cardigan',
                'description' => 'Sweater dan cardigan hangat untuk musim dingin',
                'status' => 'active',
                'image' => null
            ],
            [
                'name' => 'T-Shirt & Polo',
                'slug' => 't-shirt-polo',
                'description' => 'Kaos dan polo shirt casual',
                'status' => 'active',
                'image' => null
            ],
            [
                'name' => 'Pants',
                'slug' => 'pants',
                'description' => 'Celana berbagai model dan bahan',
                'status' => 'active',
                'image' => null
            ],
            [
                'name' => 'Skirt & Dress',
                'slug' => 'skirt-dress',
                'description' => 'Rok dan dress elegan',
                'status' => 'active',
                'image' => null
            ],
            [
                'name' => 'Accessories',
                'slug' => 'accessories',
                'description' => 'Aksesoris pelengkap fashion',
                'status' => 'active',
                'image' => null
            ]
        ];
        
        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }
        
        $this->command->info('✅ Categories created!');
        
        // ======================
        // 4. CREATE PRODUCTS
        // ======================
        $this->command->info('Creating products...');
        
        $products = [
            // Shirt & Blouse
            [
                'name' => 'Yellow Shirt',
                'slug' => 'yellow-shirt',
                'description' => 'Kemeja kuning cerah dengan bahan katun lembut',
                'price' => 175000,
                'stock' => 15,
                'size' => 'S,M,L',
                'color' => 'Yellow',
                'material' => 'Cotton',
                'category_id' => 1,
                'status' => 'available',
                'image' => null
            ],
            [
                'name' => 'Creamy White Long Sleeve Shirt',
                'slug' => 'creamy-white-long-sleeve-shirt',
                'description' => 'Kemeja lengan panjang warna cream putih',
                'price' => 275000,
                'stock' => 10,
                'size' => 'S,M,L,XL',
                'color' => 'White',
                'material' => 'Linen',
                'category_id' => 1,
                'status' => 'available',
                'image' => null
            ],
            [
                'name' => 'Choco Blouse',
                'slug' => 'choco-blouse',
                'description' => 'Blus coklat elegan dengan detail khusus',
                'price' => 199000,
                'stock' => 8,
                'size' => 'S,M,L',
                'color' => 'Brown',
                'material' => 'Polyester',
                'category_id' => 1,
                'status' => 'available',
                'image' => null
            ],
            
            // Sweater & Cardigan
            [
                'name' => 'Blue Sweater',
                'slug' => 'blue-sweater',
                'description' => 'Sweater biru hangat dengan bahan wool',
                'price' => 175000,
                'stock' => 12,
                'size' => 'S,M,L',
                'color' => 'Blue',
                'material' => 'Wool',
                'category_id' => 2,
                'status' => 'available',
                'image' => null
            ],
            [
                'name' => 'White Crop Fleece Jacket',
                'slug' => 'white-crop-fleece-jacket',
                'description' => 'Jaket fleece crop putih trendi',
                'price' => 250000,
                'stock' => 5,
                'size' => 'S,M',
                'color' => 'White',
                'material' => 'Fleece',
                'category_id' => 2,
                'status' => 'available',
                'image' => null
            ],
            
            // T-Shirt & Polo
            [
                'name' => 'Puppy Off-Shoulder T-shirt',
                'slug' => 'puppy-off-shoulder-t-shirt',
                'description' => 'Kaos off-shoulder motif puppy lucu',
                'price' => 200000,
                'stock' => 20,
                'size' => 'S,M,L',
                'color' => 'Pink',
                'material' => 'Cotton',
                'category_id' => 3,
                'status' => 'available',
                'image' => null
            ],
            
            // Pants
            [
                'name' => 'Highwaist Brown Culottes',
                'slug' => 'highwaist-brown-culottes',
                'description' => 'Celana culottes coklat highwaist',
                'price' => 1250000,
                'stock' => 7,
                'size' => 'S,M,L',
                'color' => 'Brown',
                'material' => 'Cotton',
                'category_id' => 4,
                'status' => 'available',
                'image' => null
            ],
            
            // Skirt & Dress
            [
                'name' => 'Asymmetrical Ruffle Midi Denim Skirt',
                'slug' => 'asymmetrical-ruffle-midi-denim-skirt',
                'description' => 'Rok denim midi dengan detail ruffle asimetris',
                'price' => 275000,
                'stock' => 9,
                'size' => 'S,M',
                'color' => 'Blue',
                'material' => 'Denim',
                'category_id' => 5,
                'status' => 'available',
                'image' => null
            ],
            
            // Accessories
            [
                'name' => 'Crochet Lace Bonnet',
                'slug' => 'crochet-lace-bonnet',
                'description' => 'Bonnet renda crochet handmade',
                'price' => 75000,
                'stock' => 25,
                'size' => 'One Size',
                'color' => 'White',
                'material' => 'Cotton Thread',
                'category_id' => 6,
                'status' => 'available',
                'image' => null
            ]
        ];
        
        foreach ($products as $productData) {
            Product::create($productData);
        }
        
        $this->command->info('✅ Products created!');
        
        // ======================
        // 5. CREATE PROMOTIONS
        // ======================
        $this->command->info('Creating promotions...');
        
        $promotions = [
            [
                'code' => 'MINARI10',
                'name' => 'Diskon 10% Minari',
                'description' => 'Dapatkan diskon 10% untuk semua produk',
                'type' => 'percentage',
                'value' => 10,
                'min_purchase' => 200000,
                'usage_limit' => 100,
                'start_date' => now(),
                'end_date' => now()->addMonths(3),
                'is_active' => true
            ],
            [
                'code' => 'FREESHIP',
                'name' => 'Gratis Ongkir',
                'description' => 'Gratis ongkir untuk semua wilayah',
                'type' => 'free_shipping',
                'min_purchase' => 300000,
                'usage_limit' => 50,
                'start_date' => now(),
                'end_date' => now()->addMonth(),
                'is_active' => true
            ],
            [
                'code' => 'WELCOME25',
                'name' => 'Welcome Discount 25%',
                'description' => 'Diskon 25% untuk pembeli baru',
                'type' => 'percentage',
                'value' => 25,
                'min_purchase' => 150000,
                'usage_limit' => null, // unlimited
                'start_date' => now(),
                'end_date' => now()->addYear(),
                'is_active' => true
            ]
        ];
        
        foreach ($promotions as $promoData) {
            Promotion::create($promoData);
        }
        
        $this->command->info('✅ Promotions created!');
        
        // ======================
        // 6. CREATE ORDERS
        // ======================
        $this->command->info('Creating orders...');
        
        // Function to generate order number
        $generateOrderNumber = function() {
            return 'ORD' . date('Ymd') . strtoupper(Str::random(6));
        };
        
        $order1 = Order::create([
            'order_number' => $generateOrderNumber(),
            'user_id' => $user->id,
            'customer_name' => 'John Doe',
            'customer_email' => 'user@minari.com',
            'customer_phone' => '08111222333',
            'shipping_address' => 'Jl. Contoh No. 123, Jakarta',
            'shipping_city' => 'Jakarta',
            'shipping_postal_code' => '12345',
            'subtotal' => 375000,
            'shipping_cost' => 15000,
            'tax' => 0,
            'total' => 390000,
            'payment_method' => 'bank_transfer',
            'payment_status' => 'paid',
            'order_status' => 'delivered',
            'tracking_number' => 'JTUH' . rand(100000, 999999),
            'delivered_at' => now()->subDays(5)
        ]);
        
        // Add order items
        $order1->items()->create([
            'product_id' => 1,
            'product_name' => 'Yellow Shirt',
            'price' => 175000,
            'quantity' => 1,
            'subtotal' => 175000
        ]);
        
        $order1->items()->create([
            'product_id' => 4,
            'product_name' => 'Blue Sweater',
            'price' => 200000,
            'quantity' => 1,
            'subtotal' => 200000
        ]);
        
        // Create another order
        $order2 = Order::create([
            'order_number' => $generateOrderNumber(),
            'user_id' => $user->id,
            'customer_name' => 'Aliyah Rahma',
            'customer_email' => 'aliyah@minari.com',
            'customer_phone' => '08123456789',
            'shipping_address' => 'Jl. Mawar No. 10, Bandung',
            'shipping_city' => 'Bandung',
            'shipping_postal_code' => '40257',
            'subtotal' => 450000,
            'shipping_cost' => 20000,
            'tax' => 0,
            'total' => 470000,
            'payment_method' => 'cod',
            'payment_status' => 'pending',
            'order_status' => 'processing',
        ]);
        
        $order2->items()->create([
            'product_id' => 7,
            'product_name' => 'Puppy Off-Shoulder T-shirt',
            'price' => 200000,
            'quantity' => 1,
            'subtotal' => 200000
        ]);
        
        $order2->items()->create([
            'product_id' => 9,
            'product_name' => 'Asymmetrical Ruffle Midi Denim Skirt',
            'price' => 275000,
            'quantity' => 1,
            'subtotal' => 275000
        ]);
        
        $this->command->info('✅ Orders created!');
        
        // ======================
        // 7. CREATE REVIEWS
        // ======================
        $this->command->info('Creating reviews...');
        
        Review::create([
            'user_id' => $user->id,
            'product_id' => 1,
            'order_id' => $order1->id,
            'rating' => 5,
            'comment' => 'Produk bagus, bahan lembut dan nyaman dipakai!',
            'status' => 'approved'
        ]);
        
        Review::create([
            'user_id' => 3, // Aliyah
            'product_id' => 7,
            'order_id' => $order2->id,
            'rating' => 4,
            'comment' => 'Kaosnya lucu sekali! Ukuran pas dan bahannya nyaman.',
            'status' => 'approved'
        ]);
        
        $this->command->info('✅ Reviews created!');
        
        // ======================
        // 8. CREATE WISHLIST ITEMS
        // ======================
        $this->command->info('Creating wishlist items...');
        
        $user->wishlists()->create(['product_id' => 1]); // Yellow Shirt
        $user->wishlists()->create(['product_id' => 4]); // Blue Sweater
        $user->wishlists()->create(['product_id' => 7]); // Puppy Off-Shoulder T-shirt
        
        $this->command->info('✅ Wishlist items created!');
        
        // ======================
        // FINAL MESSAGE
        // ======================
        $this->command->info('=========================================');
        $this->command->info('🎉 DATABASE SEEDING COMPLETED SUCCESSFULLY!');
        $this->command->info('=========================================');
        $this->command->info('Admin Account:');
        $this->command->info('  Email: admin@minari.com');
        $this->command->info('  Password: admin123');
        $this->command->info('  Username: admin');
        $this->command->info('');
        $this->command->info('User Account:');
        $this->command->info('  Email: user@minari.com');
        $this->command->info('  Password: password123');
        $this->command->info('  Username: johndoe');
        $this->command->info('');
        $this->command->info('Other Users:');
        $this->command->info('  Email: aliyah@minari.com (Password: password123)');
        $this->command->info('  Email: budi@minari.com (Password: password123)');
        $this->command->info('');
        $this->command->info('Promo Codes:');
        $this->command->info('  - MINARI10 (Diskon 10%)');
        $this->command->info('  - FREESHIP (Gratis Ongkir)');
        $this->command->info('  - WELCOME25 (Diskon 25% Pembeli Baru)');
        $this->command->info('=========================================');
    }
}
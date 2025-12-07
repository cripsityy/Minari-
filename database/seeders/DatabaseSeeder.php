<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        // Create Roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);
        
        // Create Permissions
        $permissions = [
            'view dashboard',
            'manage products',
            'manage categories',
            'manage orders',
            'manage users',
            'manage reviews',
            'manage promotions',
            'view reports'
        ];
        
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        
        $adminRole->givePermissionTo(Permission::all());
        $userRole->givePermissionTo(['view dashboard']);
        
        // Create Admin
        $admin = User::create([
            'name' => 'Admin Minari',
            'email' => 'admin@minari.com',
            'password' => Hash::make('admin123'),
        ]);
        $admin->assignRole('admin');
        
        // Create Regular User
        $user = User::create([
            'name' => 'Aliyah Rahma',
            'email' => 'aliyah@minari.com',
            'password' => Hash::make('user123'),
        ]);
        $user->assignRole('user');
        
        // Create Categories (Real Fashion Categories)
        $categories = [
            [
                'name' => 'Shirt & Blouse',
                'slug' => 'shirt-blouse',
                'description' => 'Koleksi kemeja dan blus wanita terbaru',
                'status' => 'active'
            ],
            [
                'name' => 'Sweater & Cardigan',
                'slug' => 'sweater-cardigan',
                'description' => 'Sweater dan cardigan hangat untuk musim dingin',
                'status' => 'active'
            ],
            [
                'name' => 'T-Shirt & Polo',
                'slug' => 't-shirt-polo',
                'description' => 'Kaos dan polo shirt casual',
                'status' => 'active'
            ],
            [
                'name' => 'Pants',
                'slug' => 'pants',
                'description' => 'Celana berbagai model dan bahan',
                'status' => 'active'
            ],
            [
                'name' => 'Skirt & Dress',
                'slug' => 'skirt-dress',
                'description' => 'Rok dan dress elegan',
                'status' => 'active'
            ],
            [
                'name' => 'Accessories',
                'slug' => 'accessories',
                'description' => 'Aksesoris pelengkap fashion',
                'status' => 'active'
            ]
        ];
        
        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }
        
        // Create Products (Real Fashion Products - Data dari asset Anda)
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
                'status' => 'available'
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
                'status' => 'available'
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
                'status' => 'available'
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
                'status' => 'available'
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
                'status' => 'available'
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
                'status' => 'available'
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
                'status' => 'available'
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
                'status' => 'available'
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
                'status' => 'available'
            ]
        ];
        
        foreach ($products as $productData) {
            Product::create($productData);
        }
        
        // Create Promotions
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
        
        // Create Sample Orders
        $order1 = \App\Models\Order::create([
            'order_number' => \App\Models\Order::generateOrderNumber(),
            'user_id' => $user->id,
            'customer_name' => 'Aliyah Rahma',
            'customer_email' => 'aliyah@minari.com',
            'customer_phone' => '08123456789',
            'shipping_address' => 'Jl. Mawar No. 10, Bandung',
            'shipping_city' => 'Bandung',
            'shipping_postal_code' => '40257',
            'subtotal' => 375000,
            'shipping_cost' => 15000,
            'tax' => 0,
            'total' => 390000,
            'payment_method' => 'cod',
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
        
        // Create Sample Reviews
        \App\Models\Review::create([
            'user_id' => $user->id,
            'product_id' => 1,
            'order_id' => $order1->id,
            'rating' => 5,
            'comment' => 'Produk bagus, bahan lembut dan nyaman dipakai!',
            'status' => 'approved'
        ]);
        
        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('✅ Admin: admin@minari.com / admin123');
        $this->command->info('✅ User: aliyah@minari.com / user123');
    }
}
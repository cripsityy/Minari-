<?php
// database/seeders/DatabaseSeeder.php (UPDATE)

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
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
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        // ======================
        // 1. CREATE ROLES & PERMISSIONS (UNTUK USER SAJA)
        // ======================
        $this->command->info('Creating roles and permissions for users...');
        
        // Create Roles hanya untuk user
        $userRole = Role::firstOrCreate(['name' => 'user']);
        Role::firstOrCreate(['name' => 'admin']); // Tetap buat untuk kompatibilitas
        
        // Create Permissions untuk user saja
        $userPermissions = [
            'view products',
            'place orders',
            'write reviews',
            'manage wishlist'
        ];
        
        foreach ($userPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        
        $userRole->syncPermissions($userPermissions);
        
        $this->command->info('✅ User roles and permissions created!');
        
        // ======================
        // 2. CREATE ADMINS (TABEL TERPISAH)
        // ======================
        $this->command->info('Creating admin accounts...');
        
        // Pastikan tabel admins ada
        if (!DB::getSchemaBuilder()->hasTable('admins')) {
            $this->command->error('Tabel admins tidak ditemukan! Jalankan migrasi terlebih dahulu.');
            return;
        }
        
        // Create Super Admin
        $superAdmin = Admin::create([
            'name' => 'Super Admin MINARI',
            'username' => 'superadmin',
            'email' => 'superadmin@minari.com',
            'password' => Hash::make('SuperAdmin123!'),
            'is_super_admin' => true,
            'secret_key' => 'MINARI_SUPER_2025',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Create Regular Admin
        $admin = Admin::create([
            'name' => 'Admin MINARI',
            'username' => 'admin',
            'email' => 'admin@minari.com',
            'password' => Hash::make('Admin123!'),
            'is_super_admin' => false,
            'secret_key' => 'MINARI_ADMIN_2025',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Create Manager
        $manager = Admin::create([
            'name' => 'Manager MINARI',
            'username' => 'manager',
            'email' => 'manager@minari.com',
            'password' => Hash::make('Manager123!'),
            'is_super_admin' => false,
            'secret_key' => 'MINARI_MANAGER_2025',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $this->command->info('✅ Admin accounts created!');
        
        // ======================
        // 3. CREATE REGULAR USERS
        // ======================
        $this->command->info('Creating regular users...');
        
        // Create Regular User
        $user = User::create([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'user@minari.com',
            'phone' => '08111222333',
            'birth_date' => '1995-05-15',
            'address' => 'Jl. Contoh No. 123, Jakarta',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
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
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Budi Santoso',
                'username' => 'budi',
                'email' => 'budi@minari.com',
                'phone' => '08234567890',
                'birth_date' => '1992-03-12',
                'address' => 'Jl. Melati No. 5, Surabaya',
                'password' => Hash::make('password123'),
            ],
        ];
        
        foreach ($sampleUsers as $userData) {
            $newUser = User::create(array_merge($userData, [
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]));
            $newUser->assignRole('user');
        }
        
        $this->command->info('✅ Regular users created!');
        
        // ======================
        // 4. DATA KOSONGAN (Sesuai Request)
        // ======================
        $this->command->info('✅ Produk, Kategori, Promosi, Order, & Review dikosongkan agar siap diisi dari Admin.');

        
        // ======================
        // FINAL MESSAGE
        // ======================
        $this->command->info('=========================================');
        $this->command->info('🎉 DATABASE SEEDING COMPLETED SUCCESSFULLY!');
        $this->command->info('=========================================');
        $this->command->info('=== ADMIN ACCOUNTS (SECRET ACCESS) ===');
        $this->command->info('🚨 IMPORTANT: Gunakan URL RAHASIA: /admin-access');
        $this->command->info('');
        $this->command->info('Super Admin:');
        $this->command->info('  URL: http://localhost/admin-access');
        $this->command->info('  Username: superadmin');
        $this->command->info('  Password: SuperAdmin123!');
        $this->command->info('');
        $this->command->info('Regular Admin:');
        $this->command->info('  URL: http://localhost/admin-access');
        $this->command->info('  Username: admin');
        $this->command->info('  Password: Admin123!');
        $this->command->info('');
        $this->command->info('Manager:');
        $this->command->info('  URL: http://localhost/admin-access');
        $this->command->info('  Username: manager');
        $this->command->info('  Password: Manager123!');
        $this->command->info('');
        $this->command->info('=== USER ACCOUNTS (PUBLIC ACCESS) ===');
        $this->command->info('Regular User:');
        $this->command->info('  URL: http://localhost/login');
        $this->command->info('  Username: johndoe');
        $this->command->info('  Password: password123');
        $this->command->info('');
        $this->command->info('Other Users:');
        $this->command->info('  Email: aliyah@minari.com (Password: password123)');
        $this->command->info('  Email: budi@minari.com (Password: password123)');
        $this->command->info('');
        $this->command->info('=== SECURITY NOTES ===');
        $this->command->info('✅ Admin dan user memiliki sistem TERPISAH');
        $this->command->info('✅ Admin TIDAK bisa login melalui /login');
        $this->command->info('✅ User TIDAK bisa login melalui /admin-access');
        $this->command->info('✅ Tampilan login SAMA (tidak mencurigakan)');
        $this->command->info('✅ Database tabel TERPISAH');
        $this->command->info('✅ Session TERPISAH');
        $this->command->info('=========================================');
    }
}
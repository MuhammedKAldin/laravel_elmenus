<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Store;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Create super admin user
        User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => User::ROLE_SUPER_ADMIN,
            ]
        );

        // Create test users
        User::firstOrCreate(
            ['email' => 'mohamed@example.com'],
            [
                'name' => 'Mohamed Kamal Aldin',
                'password' => Hash::make('test12345678'),
                'role' => User::ROLE_USER,
            ]
        );
        
        User::firstOrCreate(
            ['email' => 'hazem@example.com'],
            [
                'name' => 'Hazem Ahmed',
                'password' => Hash::make('test12345678'),
                'role' => User::ROLE_USER,
            ]
        );

        User::firstOrCreate(
            ['email' => 'osama@example.com'],
            [
                'name' => 'Osama Mohamed',
                'password' => Hash::make('test12345678'),
                'role' => User::ROLE_USER,
            ]
        );

        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => User::ROLE_ADMIN,
        ]);

        // Create regular users
        User::factory(5)->create([
            'role' => User::ROLE_USER,
        ]);

        // Create stores with their categories and products
        $this->call([
            StoreSeeder::class,
            ProductCategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use App\Enums\StoreCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StoreSeeder extends Seeder
{
    private array $storeData = [
        // Pizza Stores
        [
            'name' => 'Pizza Palace',
            'category' => StoreCategory::PIZZA,
            'description' => 'Authentic Italian pizzas made with fresh ingredients and traditional recipes. Our wood-fired oven ensures the perfect crispy crust every time.',
        ],
        // Grill Store
        [
            'name' => 'Steak House Grill',
            'category' => StoreCategory::GRILL,
            'description' => 'Premium steaks and grilled specialties. We use only the finest cuts of meat, aged to perfection and grilled to your preference.',
        ],
        // Fried Chicken Store
        [
            'name' => 'Crispy Chicken Co.',
            'category' => StoreCategory::FRIED_CHICKEN,
            'description' => 'Crispy, juicy fried chicken made with our secret blend of herbs and spices. Served with delicious sides and dipping sauces.',
        ],
        // Burger Store
        [
            'name' => 'Burger Junction',
            'category' => StoreCategory::BURGERS,
            'description' => 'Gourmet burgers made with 100% beef patties, fresh vegetables, and artisanal buns. Customize your burger with our wide selection of toppings.',
        ],
        // Eastern Food Store
        [
            'name' => 'Eastern Delights',
            'category' => StoreCategory::EASTERN_FOOD,
            'description' => 'Authentic Middle Eastern cuisine featuring traditional dishes made with fresh ingredients and authentic spices.',
        ],
        // Cafe Store
        [
            'name' => 'Urban Cafe',
            'category' => StoreCategory::CAFE,
            'description' => 'Cozy cafe serving specialty coffee, fresh pastries, and light meals. Perfect for breakfast, lunch, or a coffee break.',
        ],
        // Healthy Store
        [
            'name' => 'Fresh & Healthy',
            'category' => StoreCategory::HEALTHY,
            'description' => 'Nutritious and delicious meals made with fresh, organic ingredients. Perfect for those looking for healthy dining options.',
        ],
    ];

    public function run(): void
    {
        foreach ($this->storeData as $index => $data) {
            // Generate a unique slug
            $baseSlug = Str::slug($data['name']);
            $slug = $baseSlug;
            $counter = 1;
            
            // Keep checking until we find a unique slug
            while (Store::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $store = Store::create([
                'name' => $data['name'],
                'slug' => $slug,
                'description' => $data['description'],
                'phone' => '+1' . rand(2000000000, 9999999999),
                'email' => Str::slug($data['name']) . '@example.com',
                'logo' => 'stores/logos/store_' . ($index + 1) . '_logo.jpg',
                'cover_image' => 'stores/covers/store_' . ($index + 1) . '_cover.jpg',
                'status' => 'active',
                'category' => $data['category']->value,
                'type' => 'restaurant',
                'is_active' => true,
            ]);

            // Create admin user for the store
            $adminUser = User::create([
                'name' => $data['name'] . ' Admin',
                'email' => 'admin.' . Str::slug($data['name']) . '@example.com',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]);

            $store->update(['user_id' => $adminUser->id]);
        }
    }
} 
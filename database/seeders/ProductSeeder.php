<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $stores = Store::all();

        foreach ($stores as $store) {
            // Get product categories for this store
            $categories = ProductCategory::where('store_id', $store->id)->get();
            
            // Sample products for each category
            $products = [
                'Appetizers' => [
                    ['name' => 'Garlic Bread', 'description' => 'Freshly baked bread with garlic butter', 'price' => 5.99],
                    ['name' => 'Bruschetta', 'description' => 'Toasted bread with tomatoes and herbs', 'price' => 6.99],
                ],
                'Main Courses' => [
                    ['name' => 'Grilled Salmon', 'description' => 'Fresh salmon with lemon butter sauce', 'price' => 24.99],
                    ['name' => 'Beef Steak', 'description' => 'Premium cut beef with mushroom sauce', 'price' => 29.99],
                ],
                'Desserts' => [
                    ['name' => 'Chocolate Cake', 'description' => 'Rich chocolate cake with ganache', 'price' => 8.99],
                    ['name' => 'Tiramisu', 'description' => 'Classic Italian dessert', 'price' => 7.99],
                ],
                'Beverages' => [
                    ['name' => 'Fresh Lemonade', 'description' => 'Homemade lemonade', 'price' => 4.99],
                    ['name' => 'Iced Tea', 'description' => 'Fresh brewed iced tea', 'price' => 3.99],
                ],
                'Specials' => [
                    ['name' => 'Chef\'s Pasta', 'description' => 'Daily special pasta dish', 'price' => 19.99],
                    ['name' => 'Seafood Platter', 'description' => 'Assortment of fresh seafood', 'price' => 34.99],
                ],
            ];

            foreach ($categories as $category) {
                if (isset($products[$category->name])) {
                    foreach ($products[$category->name] as $productData) {
                        Product::create([
                            'store_id' => $store->id,
                            'category_id' => $category->id,
                            'name' => $productData['name'],
                            'description' => $productData['description'],
                            'price' => $productData['price'],
                            'image' => 'stores/products/product_' . rand(1, 20) . '.jpg',
                            'is_available' => true,
                            'is_featured' => rand(0, 1),
                        ]);
                    }
                }
            }
        }
    }
} 
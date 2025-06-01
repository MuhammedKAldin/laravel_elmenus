<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $stores = Store::all();
        
        $categories = [
            'Appetizers' => 'Start your meal with our delicious appetizers',
            'Main Courses' => 'Our signature main dishes',
            'Desserts' => 'Sweet treats to end your meal',
            'Beverages' => 'Refreshing drinks and beverages',
            'Specials' => 'Chef\'s special dishes of the day'
        ];

        foreach ($stores as $store) {
            foreach ($categories as $name => $description) {
                ProductCategory::create([
                    'store_id' => $store->id,
                    'name' => $name,
                    'description' => $description,
                    'image' => 'stores/categories/' . Str::slug($name) . '.jpg',
                ]);
            }
        }
    }
} 
<?php

namespace Database\Factories;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Store::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->company;
        $domain = Str::slug($name) . '.elmenus.com';

        return [
            'name' => $name,
            'domain' => $domain,
            'description' => $this->faker->sentence(10),
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->companyEmail,
            'logo' => $this->faker->imageUrl(200, 200, 'business'),
            'cover_image' => $this->faker->imageUrl(800, 400, 'business'),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'user_id' => null, // Will be set in configure method
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure()
    {
        return $this->afterCreating(function (Store $store) {
            // Create an admin user for the store
            $adminUser = User::factory()->create([
                'name' => $this->faker->name,
                'email' => $this->faker->unique()->safeEmail,
                'password' => bcrypt('password'),
                'is_admin' => true,
            ]);

            // Update store with admin user
            $store->update(['user_id' => $adminUser->id]);

            // Create categories for the store
            $categories = [
                ['name' => 'Appetizers', 'description' => 'Start your meal with our delicious appetizers'],
                ['name' => 'Main Courses', 'description' => 'Our signature main dishes'],
                ['name' => 'Desserts', 'description' => 'Sweet endings to your meal'],
                ['name' => 'Beverages', 'description' => 'Refreshing drinks and beverages'],
            ];

            foreach ($categories as $categoryData) {
                $category = $store->categories()->create([
                    'name' => $categoryData['name'],
                    'description' => $categoryData['description'],
                    'image' => $this->faker->imageUrl(400, 300, 'food'),
                ]);

                // Create products for each category
                $this->createProductsForCategory($category, $store);
            }
        });
    }

    /**
     * Create products for a category.
     */
    private function createProductsForCategory($category, Store $store)
    {
        $productCount = $this->faker->numberBetween(5, 10);
        
        for ($i = 0; $i < $productCount; $i++) {
            $category->products()->create([
                'store_id' => $store->id,
                'name' => $this->faker->words(3, true),
                'description' => $this->faker->sentence(8),
                'price' => $this->faker->randomFloat(2, 5, 100),
                'image' => $this->faker->imageUrl(400, 300, 'food'),
                'is_available' => $this->faker->boolean(80), // 80% chance of being available
                'is_featured' => $this->faker->boolean(20), // 20% chance of being featured
            ]);
        }
    }
} 
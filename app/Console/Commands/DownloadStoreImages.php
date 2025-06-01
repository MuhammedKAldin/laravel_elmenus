<?php

namespace App\Console\Commands;

use App\Enums\StoreCategory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class DownloadStoreImages extends Command
{
    protected $signature = 'stores:download-images';
    protected $description = 'Download images for stores, categories, and products';

    public function handle()
    {
        $this->info('Starting image download process...');

        // Create necessary directories
        $directories = [
            'stores/logos',
            'stores/covers',
            'stores/categories',
            'stores/products'
        ];

        foreach ($directories as $directory) {
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
                $this->info("Created directory: {$directory}");
            }
        }

        // Download store logos and covers
        $this->downloadStoreImages();

        // Download category images
        $this->downloadCategoryImages();

        // Download product images
        $this->downloadProductImages();

        $this->info('Image download process completed!');
    }

    private function downloadStoreImages()
    {
        $this->info('Downloading store images...');

        $storeIndex = 1;
        foreach (StoreCategory::cases() as $category) {
            foreach ($category->getExamples() as $example) {
                // Clean the example name for URL
                $searchTerm = str_replace(['\'', ' '], ['', '+'], $example);
                
                // Logo
                $logoUrl = "https://source.unsplash.com/200x200/?{$searchTerm}+restaurant+logo";
                $logoPath = "stores/logos/store_{$storeIndex}_logo.jpg";
                $this->downloadImage($logoUrl, $logoPath);

                // Cover
                $coverUrl = "https://source.unsplash.com/800x400/?{$searchTerm}+restaurant+interior";
                $coverPath = "stores/covers/store_{$storeIndex}_cover.jpg";
                $this->downloadImage($coverUrl, $coverPath);

                $storeIndex++;
            }
        }
    }

    private function downloadCategoryImages()
    {
        $this->info('Downloading category images...');

        foreach (StoreCategory::cases() as $category) {
            $searchTerm = str_replace(' ', '+', $category->value);
            $url = "https://source.unsplash.com/400x300/?{$searchTerm}+food";
            $path = "stores/categories/" . Str::slug($category->value) . ".jpg";
            $this->downloadImage($url, $path);
        }
    }

    private function downloadProductImages()
    {
        $this->info('Downloading product images...');

        $productTypes = [
            'pizza', 'burger', 'chicken', 'steak', 'salad',
            'sandwich', 'pasta', 'sushi', 'coffee', 'dessert',
            'breakfast', 'lunch', 'dinner', 'snack', 'drink',
            'appetizer', 'main+course', 'side+dish', 'soup', 'ice+cream'
        ];

        foreach ($productTypes as $index => $type) {
            $url = "https://source.unsplash.com/400x300/?{$type}+food";
            $path = "stores/products/product_" . ($index + 1) . ".jpg";
            $this->downloadImage($url, $path);
        }
    }

    private function downloadImage($url, $path)
    {
        try {
            $response = Http::get($url);
            
            if ($response->successful()) {
                Storage::disk('public')->put($path, $response->body());
                $this->info("Downloaded: {$path}");
            } else {
                $this->error("Failed to download: {$url}");
            }
        } catch (\Exception $e) {
            $this->error("Error downloading {$url}: " . $e->getMessage());
        }
    }
} 
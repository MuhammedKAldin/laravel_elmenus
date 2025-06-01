<?php

// Function to download image from URL and save it to storage
function downloadImage($url, $filename) {
    try {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        
        $contents = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            echo "cURL Error: {$error}\n";
            return false;
        }
        
        if ($contents && $httpCode === 200) {
            // Create directory if it doesn't exist
            $dir = dirname($filename);
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            
            $result = file_put_contents($filename, $contents);
            if ($result) {
                echo "Successfully downloaded and saved: {$filename}\n";
                return true;
            } else {
                echo "Failed to save file: {$filename}\n";
                return false;
            }
        } else {
            echo "HTTP Error: {$httpCode} for URL: {$url}\n";
            return false;
        }
    } catch (\Exception $e) {
        echo "Exception: " . $e->getMessage() . "\n";
        return false;
    }
}

// Create necessary directories
$directories = [
    'storage/app/public/stores/logos',
    'storage/app/public/stores/covers',
    'storage/app/public/stores/categories',
    'storage/app/public/stores/products'
];

foreach ($directories as $directory) {
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
        echo "Created directory: {$directory}\n";
    }
}

// Store images to download with direct Unsplash image IDs
$stores = [
    // Pizza Stores
    [
        'name' => 'Pizza Hut',
        'logo' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=200&h=200&fit=crop&q=80',
        'cover' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=800&h=400&fit=crop&q=80'
    ],
    [
        'name' => 'Domino\'s',
        'logo' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=200&h=200&fit=crop&q=80',
        'cover' => 'https://images.unsplash.com/photo-1574071318508-1cdbab80d002?w=800&h=400&fit=crop&q=80'
    ],
    [
        'name' => 'Papa John\'s',
        'logo' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=200&h=200&fit=crop&q=80',
        'cover' => 'https://images.unsplash.com/photo-1574071318508-1cdbab80d002?w=800&h=400&fit=crop&q=80'
    ],
    [
        'name' => 'Little Caesars',
        'logo' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=200&h=200&fit=crop&q=80',
        'cover' => 'https://images.unsplash.com/photo-1604382354936-07c5d9983bd3?w=800&h=400&fit=crop&q=80'
    ],

    // Grill Stores
    [
        'name' => 'Texas Roadhouse',
        'logo' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=200&h=200&fit=crop&q=80',
        'cover' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=800&h=400&fit=crop&q=80'
    ],
    [
        'name' => 'Outback Steakhouse',
        'logo' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=200&h=200&fit=crop&q=80',
        'cover' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=800&h=400&fit=crop&q=80'
    ],
    [
        'name' => 'LongHorn Steakhouse',
        'logo' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=200&h=200&fit=crop&q=80',
        'cover' => 'https://images.unsplash.com/photo-1546964124-0cce460f38ef?w=800&h=400&fit=crop&q=80'
    ],
    [
        'name' => 'Ruth\'s Chris',
        'logo' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=200&h=200&fit=crop&q=80',
        'cover' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=800&h=400&fit=crop&q=80'
    ],

    // Fried Chicken Stores
    [
        'name' => 'KFC',
        'logo' => 'https://images.unsplash.com/photo-1626082927389-6cd4c1f1c8b0?w=200&h=200&fit=crop&q=80',
        'cover' => 'https://images.unsplash.com/photo-1626645738196-c2a7c87a8f58?w=800&h=400&fit=crop&q=80'
    ],
    [
        'name' => 'Popeyes',
        'logo' => 'https://images.unsplash.com/photo-1626082927389-6cd4c1f1c8b0?w=200&h=200&fit=crop&q=80',
        'cover' => 'https://images.unsplash.com/photo-1626645738196-c2a7c87a8f58?w=800&h=400&fit=crop&q=80'
    ],
    [
        'name' => 'Chick-fil-A',
        'logo' => 'https://images.unsplash.com/photo-1626082927389-6cd4c1f1c8b0?w=200&h=200&fit=crop&q=80',
        'cover' => 'https://images.unsplash.com/photo-1626645738196-c2a7c87a8f58?w=800&h=400&fit=crop&q=80'
    ],
    [
        'name' => 'Church\'s Chicken',
        'logo' => 'https://images.unsplash.com/photo-1626082927389-6cd4c1f1c8b0?w=200&h=200&fit=crop&q=80',
        'cover' => 'https://images.unsplash.com/photo-1626645738196-c2a7c87a8f58?w=800&h=400&fit=crop&q=80'
    ],

    // Burger Stores
    [
        'name' => 'McDonald\'s',
        'logo' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=200&h=200&fit=crop&q=80',
        'cover' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=800&h=400&fit=crop&q=80'
    ],
    [
        'name' => 'Burger King',
        'logo' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=200&h=200&fit=crop&q=80',
        'cover' => 'https://images.unsplash.com/photo-1586816001966-79b736744398?w=800&h=400&fit=crop&q=80'
    ],
    [
        'name' => 'Wendy\'s',
        'logo' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=200&h=200&fit=crop&q=80',
        'cover' => 'https://images.unsplash.com/photo-1553979459-d2229ba7433b?w=800&h=400&fit=crop&q=80'
    ],
    [
        'name' => 'Five Guys',
        'logo' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=200&h=200&fit=crop&q=80',
        'cover' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=800&h=400&fit=crop&q=80'
    ],

    // Eastern Food Stores
    [
        'name' => 'Shawarma House',
        'logo' => 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=200&h=200&fit=crop&q=80',
        'cover' => 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=800&h=400&fit=crop&q=80'
    ],
    [
        'name' => 'Falafel Palace',
        'logo' => 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=200&h=200&fit=crop&q=80',
        'cover' => 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=800&h=400&fit=crop&q=80'
    ],
    [
        'name' => 'Kebab Corner',
        'logo' => 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=200&h=200&fit=crop&q=80',
        'cover' => 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=800&h=400&fit=crop&q=80'
    ],
    [
        'name' => 'Hummus House',
        'logo' => 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=200&h=200&fit=crop&q=80',
        'cover' => 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=800&h=400&fit=crop&q=80'
    ],

    // Cafe Stores
    [
        'name' => 'Starbucks',
        'logo' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=200&h=200&fit=crop&q=80',
        'cover' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=800&h=400&fit=crop&q=80'
    ],
    [
        'name' => 'Costa Coffee',
        'logo' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=200&h=200&fit=crop&q=80',
        'cover' => 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?w=800&h=400&fit=crop&q=80'
    ],
    [
        'name' => 'Dunkin\'',
        'logo' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=200&h=200&fit=crop&q=80',
        'cover' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=800&h=400&fit=crop&q=80'
    ],
    [
        'name' => 'Tim Hortons',
        'logo' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=200&h=200&fit=crop&q=80',
        'cover' => 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?w=800&h=400&fit=crop&q=80'
    ],

    // Healthy Stores
    [
        'name' => 'Sweetgreen',
        'logo' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=200&h=200&fit=crop&q=80',
        'cover' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=800&h=400&fit=crop&q=80'
    ],
    [
        'name' => 'Freshii',
        'logo' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=200&h=200&fit=crop&q=80',
        'cover' => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?w=800&h=400&fit=crop&q=80'
    ],
    [
        'name' => 'Just Salad',
        'logo' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=200&h=200&fit=crop&q=80',
        'cover' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=800&h=400&fit=crop&q=80'
    ],
    [
        'name' => 'Chopt',
        'logo' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=200&h=200&fit=crop&q=80',
        'cover' => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?w=800&h=400&fit=crop&q=80'
    ],
];

// Category images to download
$categories = [
    [
        'name' => 'Pizza',
        'url' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=400&h=300&fit=crop&q=80'
    ],
    [
        'name' => 'Grill',
        'url' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=400&h=300&fit=crop&q=80'
    ],
    [
        'name' => 'Fried Chicken',
        'url' => 'https://images.unsplash.com/photo-1626645738196-c2a7c87a8f58?w=400&h=300&fit=crop&q=80'
    ],
    [
        'name' => 'Burgers',
        'url' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=400&h=300&fit=crop&q=80'
    ],
    [
        'name' => 'Eastern Food',
        'url' => 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=400&h=300&fit=crop&q=80'
    ],
    [
        'name' => 'Cafe',
        'url' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=400&h=300&fit=crop&q=80'
    ],
    [
        'name' => 'Healthy',
        'url' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=400&h=300&fit=crop&q=80'
    ],
];

// Product images to download
$products = [
    [
        'name' => 'pizza',
        'url' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=400&h=300&fit=crop&q=80'
    ],
    [
        'name' => 'burger',
        'url' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=400&h=300&fit=crop&q=80'
    ],
    [
        'name' => 'chicken',
        'url' => 'https://images.unsplash.com/photo-1626082927389-6cd4c1f1c8b0?w=400&h=300&fit=crop&q=80'
    ],
    [
        'name' => 'steak',
        'url' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=400&h=300&fit=crop&q=80'
    ],
    [
        'name' => 'salad',
        'url' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=400&h=300&fit=crop&q=80'
    ],
    [
        'name' => 'sandwich',
        'url' => 'https://images.unsplash.com/photo-1528735602780-2552fd46c7af?w=400&h=300&fit=crop&q=80'
    ],
    [
        'name' => 'pasta',
        'url' => 'https://images.unsplash.com/photo-1551183053-bf91a1d81141?w=400&h=300&fit=crop&q=80'
    ],
    [
        'name' => 'sushi',
        'url' => 'https://images.unsplash.com/photo-1579871494447-9811cf80d66c?w=400&h=300&fit=crop&q=80'
    ],
    [
        'name' => 'coffee',
        'url' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=400&h=300&fit=crop&q=80'
    ],
    [
        'name' => 'dessert',
        'url' => 'https://images.unsplash.com/photo-1551024506-0bccd828d307?w=400&h=300&fit=crop&q=80'
    ],
    [
        'name' => 'breakfast',
        'url' => 'https://images.unsplash.com/photo-1533089860892-a7c6f0a88666?w=400&h=300&fit=crop&q=80'
    ],
    [
        'name' => 'lunch',
        'url' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?w=400&h=300&fit=crop&q=80'
    ],
    [
        'name' => 'dinner',
        'url' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=400&h=300&fit=crop&q=80'
    ],
    [
        'name' => 'snack',
        'url' => 'https://images.unsplash.com/photo-1550258987-190a2d41a8ba?w=400&h=300&fit=crop&q=80'
    ],
    [
        'name' => 'drink',
        'url' => 'https://images.unsplash.com/photo-1544145945-f90425340c7e?w=400&h=300&fit=crop&q=80'
    ],
    [
        'name' => 'appetizer',
        'url' => 'https://images.unsplash.com/photo-1541014741259-de529411b96a?w=400&h=300&fit=crop&q=80'
    ],
    [
        'name' => 'main-course',
        'url' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=400&h=300&fit=crop&q=80'
    ],
    [
        'name' => 'side-dish',
        'url' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=400&h=300&fit=crop&q=80'
    ],
    [
        'name' => 'soup',
        'url' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?w=400&h=300&fit=crop&q=80'
    ],
    [
        'name' => 'ice-cream',
        'url' => 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=400&h=300&fit=crop&q=80'
    ],
];

echo "Starting image download process...\n";

// Download store images
foreach ($stores as $index => $store) {
    $storeIndex = $index + 1;
    
    // Download logo
    $logoPath = "storage/app/public/stores/logos/store_{$storeIndex}_logo.jpg";
    if (downloadImage($store['logo'], $logoPath)) {
        echo "Downloaded logo: {$logoPath}\n";
    } else {
        echo "Failed to download logo: {$logoPath}\n";
    }
    
    // Download cover
    $coverPath = "storage/app/public/stores/covers/store_{$storeIndex}_cover.jpg";
    if (downloadImage($store['cover'], $coverPath)) {
        echo "Downloaded cover: {$coverPath}\n";
    } else {
        echo "Failed to download cover: {$coverPath}\n";
    }
}

// Download category images
foreach ($categories as $category) {
    $path = "storage/app/public/stores/categories/" . strtolower(str_replace(' ', '_', $category['name'])) . ".jpg";
    if (downloadImage($category['url'], $path)) {
        echo "Downloaded category: {$path}\n";
    } else {
        echo "Failed to download category: {$path}\n";
    }
}

// Download product images
foreach ($products as $index => $product) {
    $path = "storage/app/public/stores/products/product_" . ($index + 1) . ".jpg";
    if (downloadImage($product['url'], $path)) {
        echo "Downloaded product: {$path}\n";
    } else {
        echo "Failed to download product: {$path}\n";
    }
}

echo "Image download completed!\n"; 
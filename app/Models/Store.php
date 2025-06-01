<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'domain',
        'description',
        'logo',
        'type',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function productCategories()
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
} 
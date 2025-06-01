<?php

namespace App\Models;

use App\Traits\BelongToStore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use BelongToStore, HasFactory;

    protected $fillable = [
        'store_id',
        'category_id',
        'name',
        'description',
        'price',
        'image',
        'is_available',
        'is_featured'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
        'is_featured' => 'boolean'
    ];

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }
} 
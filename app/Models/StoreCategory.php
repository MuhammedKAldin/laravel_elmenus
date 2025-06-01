<?php

namespace App\Models;

use App\Traits\BelongToStore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StoreCategory extends Model
{
    use BelongToStore, HasFactory;

    protected $table = 'store_categories';

    protected $fillable = [
        'store_id',
        'name',
        'description',
        'image',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
} 
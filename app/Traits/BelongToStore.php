<?php

namespace App\Traits;

use App\Models\Store;

trait BelongToStore
{
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('store', function ($query) {
            $store = app()->make('store.active');
            $query->where('store_id', $store->id);
        });
    }
} 
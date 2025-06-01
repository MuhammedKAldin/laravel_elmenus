<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait BelongsToOwner
{
    protected function getStore()
    {
        return app()->get('store.active');
    }

    protected function validateStore()
    {
        $store = $this->getStore();
        if (!$store) {
            abort(404, 'Store not found');
        }
        return $store;
    }

    protected function authorizeStoreAccess($store)
    {
        if (!$store || Auth::user()->store_id !== $store->id) {
            abort(403, 'Unauthorized access to store');
        }
        return $store;
    }

    protected function getAuthorizedStore()
    {
        $store = $this->validateStore();
        return $this->authorizeStoreAccess($store);
    }
} 
<?php

namespace App\Policies;

use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductCategoryPolicy
{
    use HandlesAuthorization;

    public function update(User $user, ProductCategory $productCategory)
    {
        return $user->store->id === $productCategory->store_id;
    }

    public function delete(User $user, ProductCategory $productCategory)
    {
        return $user->store->id === $productCategory->store_id;
    }
} 
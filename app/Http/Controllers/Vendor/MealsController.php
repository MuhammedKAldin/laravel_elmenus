<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MealsController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;
        
        $items = $store->products()
            ->with('productCategory')
            ->latest()
            ->paginate(10);

        $categories = $store->productCategories()
            ->withCount('products')
            ->get();

        return view('vendor.meals', compact('items', 'categories'));
    }
} 
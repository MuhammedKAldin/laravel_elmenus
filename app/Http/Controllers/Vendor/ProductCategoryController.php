<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;
        $categories = $store->productCategories()
            ->with(['products' => function($query) {
                $query->select('id', 'product_category_id');
            }])
            ->withCount('products')
            ->get();
        return view('vendor.product-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('vendor.product-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $store = Auth::user()->store;
        $store->productCategories()->create($request->all());

        return redirect()->route('vendor.product-categories.index')
            ->with('success', 'Product category created successfully.');
    }

    public function edit(ProductCategory $productCategory)
    {
        $this->authorize('update', $productCategory);
        return view('vendor.product-categories.edit', compact('productCategory'));
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        $this->authorize('update', $productCategory);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $productCategory->update($request->all());

        return redirect()->route('vendor.product-categories.index')
            ->with('success', 'Product category updated successfully.');
    }

    public function destroy(ProductCategory $productCategory)
    {
        $this->authorize('delete', $productCategory);

        if ($productCategory->products()->count() > 0) {
            return back()->with('error', 'Cannot delete category with associated products.');
        }

        $productCategory->delete();

        return redirect()->route('vendor.product-categories.index')
            ->with('success', 'Product category deleted successfully.');
    }
} 
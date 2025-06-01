<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('store_id', Auth::user()->store->id)->get();
        return view('vendor.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('vendor.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'store_id' => Auth::user()->store->id,
        ]);

        return redirect()->route('vendor.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        if ($category->store_id !== Auth::user()->store->id) {
            abort(403);
        }
        return view('vendor.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        if ($category->store_id !== Auth::user()->store->id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('vendor.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->store_id !== Auth::user()->store->id) {
            abort(403);
        }

        $category->delete();

        return redirect()->route('vendor.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
} 
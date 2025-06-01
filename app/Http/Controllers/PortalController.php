<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function index()
    {
        $featuredProducts = \App\Models\Product::where('is_featured', true)
            ->with(['store', 'productCategory'])
            ->latest()
            ->take(6)
            ->get();

        return view('index', compact('featuredProducts'));
    }

    public function menus()
    {
        $stores = Store::all();
        return view('menus', compact('stores'));
    }

    public function openMenu($slug)
    {
        $store = Store::where('slug', $slug)
            ->with(['categories.products', 'posts' => function($query) {
                $query->latest()->take(5);
            }])
            ->firstOrFail();

        return view('menu', compact('store'));
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('query');
    
        // Search across multiple fields
        $stores = Store::where('name', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('address', 'LIKE', '%' . $searchTerm . '%')
            ->get();
    
        return view('menus', compact('stores', 'searchTerm'));
    }
}

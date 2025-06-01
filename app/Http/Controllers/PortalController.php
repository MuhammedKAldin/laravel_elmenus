<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function menus()
    {
        // $vendors = Vendor::all();
        // return view('menus', compact('vendors'));

        $stores = Store::where('status', 'active')->get();
        return view('menus', compact('stores'));
    }

    public function openMenu($id)
    {
        $store = Store::with(['categories.products'])->findOrFail($id);
        return view('menu', compact('store'));
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('query');
    
        // Search the Store model based on the search term
        $results = Store::where('status', 'active')
            ->where(function($query) use ($searchTerm) {
                $query->where('name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('address', 'LIKE', '%' . $searchTerm . '%');
            })
            ->get();
    
        // Return the search results as JSON for AJAX
        return response()->json($results);
    }
}

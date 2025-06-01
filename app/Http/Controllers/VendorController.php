<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Store;
use App\Models\MenuItem;
use App\Traits\BelongsToOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\VendorService;

class VendorController extends Controller
{
    use BelongsToOwner;

    protected $vendorService;

    public function __construct(VendorService $vendorService)
    {
        $this->vendorService = $vendorService;
        $this->middleware(function ($request, $next) {
            $this->getAuthorizedStore();
            return $next($request);
        });
    }

    public function vendorProfile()
    {
        $store = $this->getAuthorizedStore();
        return view('vendor.profile', compact('store'));
    }

    public function updateProfile(Request $request)
    {
        $store = $this->getAuthorizedStore();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
        ]);

        $store->update($validated);

        return redirect()->route('vendor.profile')
            ->with('success', 'Profile updated successfully');
    }
    
    public function meals(Request $request)
    {
        $store = $this->getAuthorizedStore();
        
        $query = $store->products()->with('productCategory');

        // Handle search
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        $items = $query->latest()->paginate(10)->withQueryString();

        $categories = $store->productCategories()
            ->withCount('products')
            ->get();

        return view('vendor.meals', compact('items', 'categories'));
    }

    public function vendorCreate()
    {
        $store = $this->getAuthorizedStore();
        return view('vendor.create-meal', compact('store'));
    }

    public function vendorCreateProcess(Request $request)
    {
        $store = $this->getAuthorizedStore();
        $this->vendorService->createMeal($request, $store);
        return redirect()->route('vendor.meals')->with('success','Meal added successfully');
    }

    public function vendorShowMeal($id)
    {
        $store = $this->getAuthorizedStore();
        $item = $this->vendorService->getMealById($id, $store);
        
        // Additional check to ensure the meal belongs to the store
        if (!$item || $item->store_id !== $store->id) {
            abort(403, 'Unauthorized access to meal');
        }
        
        return view('vendor.show-meal', compact('item', 'store'));
    }

    public function editMealProcess(Request $request, $id)
    {
        $store = $this->getAuthorizedStore();
        $item = $this->vendorService->getMealById($id, $store);
        
        // Additional check to ensure the meal belongs to the store
        if (!$item || $item->store_id !== $store->id) {
            abort(403, 'Unauthorized access to meal');
        }
        
        $this->vendorService->editMeal($request, $id, $store);
        return redirect()->route('vendor.meals.show', ['id' => $id])
               ->with('success', 'Meal updated successfully!');
    }

    public function removeMeal($id)
    {
        $store = $this->getAuthorizedStore();
        $item = $this->vendorService->getMealById($id, $store);
        
        // Additional check to ensure the meal belongs to the store
        if (!$item || $item->store_id !== $store->id) {
            abort(403, 'Unauthorized access to meal');
        }
        
        $this->vendorService->removeMeal($id, $store);
        return redirect()->route('vendor.meals');
    }

    public function vendorSearchMeals(Request $request)
    {
        $store = $this->getAuthorizedStore();
        $results = $this->vendorService->searchMeals($request, $store);
        return response()->json($results);
    }
}

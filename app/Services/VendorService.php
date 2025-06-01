<?php

namespace App\Services;

use App\Models\Store;
use App\Models\Vendor;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VendorService
{
    public function getVendorProfile(Store $store)
    {
        return $store;
    }

    public function getVendorMeals(Store $store)
    {
        return $store->products;
    }

    public function createMeal(Request $request, Store $store)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/products', $imageName);
            $data['image'] = 'products/' . $imageName;
        }

        $data['store_id'] = $store->id;
        
        return $store->products()->create($data);
    }

    public function getMealById($id, Store $store)
    {
        return $store->products()->findOrFail($id);
    }

    public function editMeal($request, $id, Store $store)
    {
        $product = $store->products()->findOrFail($id);
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $request->image,
            'category_id' => $request->category_id
        ]);
    }

    public function removeMeal($id, Store $store)
    {
        $store->products()->findOrFail($id)->delete();
    }

    public function searchMeals($request, Store $store)
    {
        return $store->products()
            ->where('name', 'like', '%' . $request->search . '%')
            ->orWhere('description', 'like', '%' . $request->search . '%')
            ->get();
    }
} 
<?php

namespace App\Services;

use App\Models\Vendor;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorService
{
    public function getVendorProfile()
    {
        $id = Auth::user()->id;
        return Vendor::where('verified_user_id', $id)->first();
    }

    public function getVendorMeals()
    {
        $id = Auth::user()->id;
        return MenuItem::where('vendor_id', $id)->get();
    }

    public function createMeal(Request $request)
    {
        $request->validate([
            'meal_name' => 'required',
            'meal_price' => 'required',
            'meal_category' => 'required|in:grill,fried chicken,pizza,burger',
            'meal_desc' => 'required',
            'meal_image' => 'required|image',
        ]);
        $data = $request->all();
        $data['vendor_id'] = Auth::user()->id;
        $data['meal_availability'] = "available";
        if ($request->hasFile('meal_image')) {
            $image = $request->file('meal_image');
            $destinationPath = 'storage/meals/';
            $imageName = date('YmdHis').".".$image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
            $data['meal_image'] = $imageName;
        }
        MenuItem::create($data);
    }

    public function getMealById($id)
    {
        return MenuItem::where('id', $id)->first();
    }

    public function editMeal(Request $request, $id)
    {
        $input = $request->all();
        $item = MenuItem::findOrFail($id);
        $item->update($input);
    }

    public function removeMeal($id)
    {
        $item = MenuItem::findOrFail($id);
        $item->delete();
    }

    public function searchMeals(Request $request)
    {
        $searchTerm = $request->input('query');
        return MenuItem::where('meal_name', 'LIKE', '%' . $searchTerm . '%')->get();
    }
} 
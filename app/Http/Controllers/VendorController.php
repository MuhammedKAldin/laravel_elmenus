<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vendor;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\VendorService;

class VendorController extends Controller
{
    protected $vendorService;

    public function __construct(VendorService $vendorService)
    {
        $this->vendorService = $vendorService;
    }

    public function vendorProfile()
    {
        $user = $this->vendorService->getVendorProfile();
        return view('vendor.profile', compact('user'));
    }
    
    public function vendorMeals()
    {
        $items = $this->vendorService->getVendorMeals();
        return view('vendor.meals', compact('items'));
    }

    public function vendorCreate()
    {
        return view('vendor.create-meal');
    }

    public function vendorCreateProcess(Request $request)
    {
        $this->vendorService->createMeal($request);
        return redirect()->route('vendorCreate')->with('success','Meal added successfully');
    }

    // public function vendorNewMeal()
    // {
    //     return view('vendor.meals');
    // }
    
    // public function newMealProcess(Request $request)
    // {

    // }

    public function vendorShowMeal($id)
    {
        $item = $this->vendorService->getMealById($id);
        return view('vendor.show-meal', compact('item'));
    }

    public function editMealProcess(Request $request, $id)
    {
        $this->vendorService->editMeal($request, $id);
        return redirect()->route('vendorShowMeal', ['id' => $id])
               ->with('success', 'Meal updated successfully!');
    }

    public function removeMeal($id)
    {
        $this->vendorService->removeMeal($id);
        return redirect()->route('vendorMeals');
    }

    public function vendorSearchMeals(Request $request)
    {
        $results = $this->vendorService->searchMeals($request);
        return response()->json($results);
    }
}

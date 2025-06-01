<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymobController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\MobileWalletController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Vendor\CategoryController as VendorCategoryController;
use App\Http\Controllers\Vendor\PostController as VendorPostController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Vendor\ProductCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// Base Laravel/UI Home
Route::get('/home', [HomeController::class, 'index'])->name('home');

// -------------------------------------------------------------
// Home Page (All Users)
Route::get('/', [PortalController::class, 'index'])->name('index');

// Displaying All Restraunts Found (All Users) 
Route::get('/menus', [PortalController::class, 'menus'])->name('menus');

// Search Restaurants on Menu (All Users)
Route::get('/search', [PortalController::class, 'search'])->name('search');

// Cart (All Users)
Route::get('/cart', [CartController::class, 'cart'])->name('cart');

// Displaying Menu of a Selected Restarunt with Id (All Users)
Route::get('/menus/{slug}', [PortalController::class, 'openMenu'])->name('openMenu');

// -------------------------------------------------------------
// Tenant Routes (Vendors Profile Management)
Route::middleware(['auth', 'storeOwner'])->prefix('vendor')->name('vendor.')->group(function () {
    // Restraunt General Data (Vendor)
    Route::get('/general', [VendorController::class, 'vendorProfile'])->name('profile');
    Route::put('/general', [VendorController::class, 'updateProfile'])->name('profile.update');

    // Restraunt Meals Data (Vendor)
    Route::get('/meals', [VendorController::class, 'meals'])->name('meals');

    // Search Meals on Menu (Vendor)
    Route::get('/search', [VendorController::class, 'vendorSearchMeals'])->name('search');

    // Create New Meal (Vendor)
    Route::get('/create', [VendorController::class, 'vendorCreate'])->name('create');

    // Process New Meal Created (Vendor)
    Route::post('/create/process', [VendorController::class, 'vendorCreateProcess'])->name('create.process');

    // Display Meal Id Data (Vendor)
    Route::get('/meals/{id}', [VendorController::class, 'vendorShowMeal'])->name('meals.show');

    // Update Data of Meal by Id (Vendor)
    Route::put('/meals/{id}/process', [VendorController::class, 'editMealProcess'])->name('meals.update');

    // Remove Meal Data (Vendor)
    Route::get('/meals/{id}/remove', [VendorController::class, 'removeMeal'])->name('meals.remove');

    // Categories Routes
    Route::get('/categories/create', [VendorCategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories/store', [VendorCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories', [VendorCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/{category}/edit', [VendorCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [VendorCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [VendorCategoryController::class, 'destroy'])->name('categories.destroy');

    // Posts Routes
    Route::get('/posts/create', [VendorPostController::class, 'create'])->name('posts.create');
    Route::post('/posts/store', [VendorPostController::class, 'store'])->name('posts.store');
    Route::get('/posts', [VendorPostController::class, 'index'])->name('posts.index');
    Route::get('/posts/{post}/edit', [VendorPostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [VendorPostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [VendorPostController::class, 'destroy'])->name('posts.destroy');

    Route::resource('product-categories', ProductCategoryController::class);
});

// -------------------------------------------------------------
// Paymob Payment Routes (All Users) //
// Paymob Payment Sending Data (Performing Credit Card Payment)
Route::post('/credit', [PaymobController::class, 'credit'])->name('checkout');

// Paymob Payment Sending Data (Performing Mobile Wallet Payment)
// Route::post('/wallet', [PaymobController::class, 'wallet'])->name('wallet');

// Paymob Response
Route::get('/callback', [PaymobController::class, 'callback'])->name('callback'); 

Route::middleware(['auth', 'setActiveStore'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
}); 

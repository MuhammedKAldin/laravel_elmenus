<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'super_admin'])->group(function () {
    // Super Admin Dashboard
    Route::get('/super-admin/dashboard', function () {
        return view('super_admin.dashboard');
    })->name('super_admin.dashboard');

    // Store Management
    Route::get('/super-admin/stores', [App\Http\Controllers\SuperAdmin\StoreController::class, 'index'])->name('super_admin.stores.index');
    Route::get('/super-admin/stores/{store}', [App\Http\Controllers\SuperAdmin\StoreController::class, 'show'])->name('super_admin.stores.show');
    Route::get('/super-admin/stores/{store}/edit', [App\Http\Controllers\SuperAdmin\StoreController::class, 'edit'])->name('super_admin.stores.edit');
    Route::put('/super-admin/stores/{store}', [App\Http\Controllers\SuperAdmin\StoreController::class, 'update'])->name('super_admin.stores.update');
    Route::delete('/super-admin/stores/{store}', [App\Http\Controllers\SuperAdmin\StoreController::class, 'destroy'])->name('super_admin.stores.destroy');

    // User Management
    Route::get('/super-admin/users', [App\Http\Controllers\SuperAdmin\UserController::class, 'index'])->name('super_admin.users.index');
    Route::get('/super-admin/users/{user}', [App\Http\Controllers\SuperAdmin\UserController::class, 'show'])->name('super_admin.users.show');
    Route::get('/super-admin/users/{user}/edit', [App\Http\Controllers\SuperAdmin\UserController::class, 'edit'])->name('super_admin.users.edit');
    Route::put('/super-admin/users/{user}', [App\Http\Controllers\SuperAdmin\UserController::class, 'update'])->name('super_admin.users.update');
    Route::delete('/super-admin/users/{user}', [App\Http\Controllers\SuperAdmin\UserController::class, 'destroy'])->name('super_admin.users.destroy');
}); 
<?php

use App\Http\Controllers\Backend\VendorController;
use App\Http\Controllers\Backend\VendorProfileController;
use App\Http\Controllers\Backend\VendorShopProfileController;
use App\Http\Controllers\Backend\VendorProductController;
use App\Http\Controllers\Backend\VendorProductImageGalleryController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard' , [VendorController::class , 'dashboard'])->name('dashboard');

Route::get('/profile', [VendorProfileController::class, 'index'])->name('profile');

Route::put('profile/update', [VendorProfileController::class, 'updateProfile'])->name('profile.update');

Route::put('profile/update/password', [VendorProfileController::class, 'updatePassword'])->name('profile.update.password');

// Vendor Profile Routes
Route::resource('shop-profile', VendorShopProfileController::class);

/** Product Routes */
Route::get('products/get-sub-categories', [VendorProductController::class, 'getSubCategories'])->name('products.get-sub-categories');
Route::get('products/get-child-categories', [VendorProductController::class, 'getChildCategories'])->name('products.get-child-categories');
Route::resource('products', VendorProductController::class);

/** Product Iamge Gallery */
Route::resource('product-image-gallery', VendorProductImageGalleryController::class);

<?php

use App\Http\Controllers\Backend\VendorController;
use App\Http\Controllers\Backend\VendorProfileController;
use App\Http\Controllers\Backend\VendorShopProfileController;
use App\Http\Controllers\Backend\VendorProductController;
use App\Http\Controllers\Backend\VendorProductImageGalleryController;
use App\Http\Controllers\Backend\VendorProductVariantController;
use App\Http\Controllers\Backend\VendorProductVariantItemController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard' , [VendorController::class , 'dashboard'])->name('dashboard');

Route::get('/profile', [VendorProfileController::class, 'index'])->name('profile');

Route::put('profile/update', [VendorProfileController::class, 'updateProfile'])->name('profile.update');

Route::put('profile/update/password', [VendorProfileController::class, 'updatePassword'])->name('profile.update.password');

// Vendor Profile Routes
Route::resource('shop-profile', VendorShopProfileController::class);

/** Product Routes */
Route::put('products/change-status', [VendorProductController::class, 'changeStatus'])->name('products.change-status');
Route::get('products/get-sub-categories', [VendorProductController::class, 'getSubCategories'])->name('products.get-sub-categories');
Route::get('products/get-child-categories', [VendorProductController::class, 'getChildCategories'])->name('products.get-child-categories');
Route::resource('products', VendorProductController::class);

/** Product Iamge Gallery */
Route::resource('product-image-gallery', VendorProductImageGalleryController::class);

Route::put('products-variant/change-status', [VendorProductVariantController::class, 'changeStatus'])->name('products-variant.change-status');
Route::resource('products-variant', VendorProductVariantController::class);

Route::put('products-variant-item/change-status', [VendorProductVariantItemController::class, 'changeStatus'])->name('products-variant-item.change-status');
Route::get('products-variant-item/{productId}/{variantId}', [VendorProductVariantItemController::class, 'index'])->name('products-variant-item.index');
Route::get('products-variant-item/{variantId}', [VendorProductVariantItemController::class, 'create'])->name('products-variant-item.create');
Route::post('product-variant-item', [VendorProductVariantItemController::class, 'store'])->name('products-variant-item.store');
Route::get('products-variant-item-edit/{variantItemId}', [VendorProductVariantItemController::class, 'edit'])->name('products-variant-item.edit');
Route::put('products-variant-item-update/{variantItemId}', [VendorProductVariantItemController::class, 'update'])->name('products-variant-item.update');
Route::delete('products-variant-item/{variantItemId}', [VendorProductVariantItemController::class, 'destroy'])->name('products-variant-item.destroy');

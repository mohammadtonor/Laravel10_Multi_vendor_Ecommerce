<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ChildCategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard' , [AdminController::class , 'dashboard'])->name('dashboard');

/** Profile Route */
Route::get('profile', [ProfileController::class, 'index'])->name('profile');
Route::post('profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::post('profile/update/password', [ProfileController::class, 'updatePassword'])->name('password.update');

/* Slider Routes */
Route::resource('slider', SliderController::class);

/* Category Routes */
Route::put('category/change-status', [CategoryController::class, 'changeStatus'])->name('category.change-status');
Route::resource('category', CategoryController::class);

/* Sub Category Routes */
Route::put('subcategory/change-status', [SubCategoryController::class, 'changeStatus'])->name('subcategory.change-status');
Route::resource('sub-category', SubCategoryController::class);

/* Child Category Routes */
Route::put('childcategory/change-status', [ChildCategoryController::class, 'changeStatus'])->name('child-category.change-status');
Route::get('get-sub-category', [ChildCategoryController::class, 'getSubCategory'])->name('child-category.get-sub-category');
Route::resource('child-category', ChildCategoryController::class);
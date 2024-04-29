<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SellerPendingProductDataTable;
use App\DataTables\SellerProductDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SellerProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SellerProductDataTable $datatabe)
    {
        return $datatabe->render('admin.product.seller-product.index');
    }


    public function pendingProductsIndex(SellerPendingProductDataTable $datatabe)
    {
        return $datatabe->render('admin.product.seller-pending-product.index');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    /**
     * Display the specified resource.
     */
    public function changeSellerApproving(Request $request)
    {
        $sellerProduct = Product::findOrFail($request->id);
        $sellerProduct->is_approved = $request->is_approved;
        $sellerProduct->save();
        return response(['status' => 'success', 'message' => 'prudcy Approved succesfully']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

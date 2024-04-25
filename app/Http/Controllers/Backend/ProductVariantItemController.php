<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Datatables\ProductVariantItemDataTable;
use App\Models\Product;
use App\Models\ProductVariant;

class ProductVariantItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductVariantItemDataTable $datatable, $productId, $variantId)
    {
        $product = Product::findOrFail($productId);
        $variant = ProductVariant::findOrFail($variantId);
        return $datatable->render('admin.product.product-variant-item.index', compact('product', 'variant'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        $variant = ProductVariant::findOrFail($id);
        return view('admin.product.product-variant-item.create', compact( 'variant'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [ 'required', 'max:20'],
            'variant_id' => ['integer', 'required'],
            'price' => ['required', 'integer'],
            'is_default' => ['required'],
            'status' => ['required']
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

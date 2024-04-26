<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductVariantDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantItem;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ProductVariantDataTable $datatable)
    {   $product = Product::findOrFail($request->product);
        return $datatable->render('admin.product.product-variant.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.product.product-variant.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product' => ['required', 'integer'],
            'name' => ['required', 'max:200'],
            'status' => ['required',],
        ]);

        $productVariant = new ProductVariant();
        $productVariant->product_id = $request->product;
        $productVariant->name = $request->name;
        $productVariant->status = $request->status;
        $productVariant->save();

        toastr('ProductVariant Created successfully' , 'success');

        return redirect()->route('admin.product-variant.index', ['product' => $request->product]);
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
        $productVariant = ProductVariant::findOrFail($id);
        return view('admin.product.product-variant.edit', compact('productVariant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'product' => ['required', 'integer'],
            'name' => ['required', 'max:200'],
            'status' => ['required',],
        ]);

        $productVariant = ProductVariant::findOrFail($id);
        $productVariant->product_id = $request->product;
        $productVariant->name = $request->name;
        $productVariant->status = $request->status;
        $productVariant->save();

        toastr('ProductVariant updated successfully' , 'success');

        return redirect()->route('admin.product-variant.index', ['product' => $request->product]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $productVariant = $productVariant = ProductVariant::findOrFail($id);
        $variantItemCount = ProductVariantItem::where('product_variant_id', $productVariant->id)->count();
        if($variantItemCount > 0 ) {
            return response(['status' => 'error' , 'message' => 'This variant has items in it delete the variant item, firt for delete variant item']);
        }
        $productVariant->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully']);
    }

    public function changeStatus (Request $request) {
        $productVariant = ProductVariant::findOrFail($request->id);

        $productVariant->status = $request->isChecked == 'true' ? 1 : 0;
        $productVariant->save();

        return response(['status' => 'success', 'message' => 'Status upfdated successfully']);
    }
}

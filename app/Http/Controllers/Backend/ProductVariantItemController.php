<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Datatables\ProductVariantItemDataTable;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantItem;

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

        $variant = ProductVariant::findOrFail($request->variant_id);

        $variantItem = new ProductVariantItem();
        $variantItem->name = $request->name;
        $variantItem->product_variant_id = $request->variant_id;
        $variantItem->price = $request->price;
        $variantItem->is_default = $request->is_default;
        $variantItem->status = $request->status;
        $variantItem->save();

        toastr('Variant Item created successfully', 'success');
        return redirect()->route('admin.product-variant-item.index', ['productId' => $variant->product_id,'variantId' => $request->variant_id]);
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
        $variantItem = ProductVariantItem::findOrFail($id);
        $variant = ProductVariant::findOrFail($variantItem->product_variant_id);
        return view('admin.product.product-variant-item.edit', compact( 'variantItem', 'variant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => [ 'required', 'max:20'],
            'variant_id' => ['integer', 'required'],
            'price' => ['required', 'integer'],
            'is_default' => ['required'],
            'status' => ['required']
        ]);

        $variant = ProductVariant::findOrFail($request->variant_id);

        $variantItem = ProductVariantItem::findOrFail($id);
        $variantItem->name = $request->name;
        $variantItem->product_variant_id = $request->variant_id;
        $variantItem->price = $request->price;
        $variantItem->is_default = $request->is_default;
        $variantItem->status = $request->status;
        $variantItem->save();

        toastr('Variant Item Updated successfully', 'success');
        return redirect()->route('admin.product-variant-item.index', ['productId' => $variantItem->productVariant->product_id,'variantId' => $variantItem->product_variant_id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $variantItem = ProductVariantItem::findOrFail($id);
        $variantItem->delete();

        return response(['status' => 'success', 'message' => 'Variant Item Deleted successfully']);
    }

    public function changeStatus (Request $request) {
        $variantItem = ProductVariantItem::findOrFail($request->id);
        $variantItem->status = $request->isChecked == 'true' ? 1 : 0;
        $variantItem->save();

        return response(['status' => 'success', 'message' => 'Status updated successfully']);
    }
}

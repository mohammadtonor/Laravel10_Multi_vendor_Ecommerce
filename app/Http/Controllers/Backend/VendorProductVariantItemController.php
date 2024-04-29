<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\VendorProductVariantItemDataTable;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantItem;
use App\Http\Repositories\ProductRepo;


class VendorProductVariantItemController extends Controller
{
    private ProductRepo $productRepo;
    public function __construct(ProductRepo $productRepo) {
        $this->productRepo = $productRepo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(VendorProductVariantItemDataTable $datable, $productId, $variantId)
    {
        $product = Product::findOrFail($productId);
        $variant = ProductVariant::findOrFail($variantId);
        return $datable->render('vendor.product.product-variant-item.index', compact('product', 'variant'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $variantId)
    {
        $variant = ProductVariant::findOrFail($variantId);
        return view('vendor.product.product-variant-item.create', compact('variant'));
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

        $response = $this->productRepo->storeProductVariantItem(
            $request->name,
            $request->variant_id,
            $request->price,
            $request->is_default,
            $request->status
        );

        if($response['status'] == 'success') {
            toastr('ProductVariants Created successfully' , 'success');
            return redirect()->route('vendor.products-variant-item.index', ['productId' => $request->product_id,'variantId' => $request->variant_id]);
        } else {
            toastr('ProductVariant Creating  error' , 'error');
            return redirect()->route('vendor.products-variant.create', ['variant' => $request->product]);
        }
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
        return view('vendor.product.product-variant-item.edit', compact('variantItem'));
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

        $response = $this->productRepo->updateProductVariantItem(
            $id,
            $request->name,
            $request->variant_id,
            $request->price,
            $request->is_default,
            $request->status
        );
        $productVarinat = $this->productRepo->getProductVariant($request->variant_id);
        if($response['status'] == 'success') {
            toastr('ProductVariants Updated successfully' , 'success');
            return redirect()->route('vendor.products-variant-item.index', ['productId' => $productVarinat->product_id,'variantId' => $productVarinat->id]);
        } else {
            toastr('ProductVariant Updatying error' , 'error');
            return redirect()->route('vendor.products-variant.edit', ['variant' => $id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->productRepo->deleteProductVariantItem($id);
        return $response['status'] == 'success'
            ? response(['status' => 'success', 'message' => 'Deleted Successfully!'])
            : response(['status' => 'error', 'message' => 'Error occured Deleting!']) ;
    }
}

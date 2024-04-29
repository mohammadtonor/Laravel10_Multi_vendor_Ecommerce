<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorProductVariantDataTable;
use App\Models\ProductVariant;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Repositories\ProductRepo;

class VendorProductVariantController extends Controller
{
    private ProductRepo $productRepo;
    public function __construct(ProductRepo $productRepo) {
        $this->productRepo = $productRepo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, VendorProductVariantDataTable $datatable)
    {
        $product = Product::FindOrFail($request->product);
        return $datatable->render('vendor.product.product-variant.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vendor.product.product-variant.create');
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
        $response = $this->productRepo->storeProductVariant($request->name, $request->product, $request->status);
        if($response['status'] == 'success') {
            toastr('ProductVariants Created successfully' , 'success');
            return redirect()->route('vendor.products-variant.index', ['product' => $request->product]);
        } else {
            toastr('ProductVariant Creating  error' , 'error');
            return redirect()->route('vendor.products-variant.create', ['product' => $request->product]);
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
        $varinat = ProductVariant::findOrFail($id);
        return view('vendor.product.product-variant.edit', compact('varinat'));
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
        $response = $this->productRepo->updateProductVariant($id,$request->name, $request->product, $request->status);
        if($response['status'] == 'success') {
            toastr('ProductVariants Updated successfully' , 'success');
            return redirect()->route('vendor.products-variant.index', ['product' => $request->product]);
        } else {
            toastr('ProductVariant Updating  error' , 'error');
            return redirect()->route('vendor.products-variant.create', ['product' => $request->product]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->productRepo->deleteProductVariant($id);
        return $response['status'] == 'success'
            ? response(['status' => 'success', 'message' => 'Image Deleted Successfully!'])
            : response(['status' => 'error', 'message' => 'Error occured Deleting!']) ;
    }

    public function changeStatus (Request $request) {
        $response = $this->productRepo->changeProductVariantstatus($request->id, $request->isChecked);
        return $response['status'] == 'success'
            ? response(['status' => 'success', 'message' => 'Status Updated Successfully!'])
            : response(['status' => 'error', 'message' => 'Error occured Updaying!']) ;
    }
}

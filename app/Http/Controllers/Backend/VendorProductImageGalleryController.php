<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\VendorProductImageGalleryDataTable;
use App\Models\Product;
use App\Http\Repositories\ProductRepo;
use App\Models\ProductImageGallery;
use Illuminate\Support\Facades\Auth;

class VendorProductImageGalleryController extends Controller
{
    private ProductRepo $productRepo;
    public function __construct(ProductRepo $productRepo) {
        $this->productRepo = $productRepo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, VendorProductImageGalleryDataTable $datatable)
    {
        $product = Product::findOrFail($request->product);
        if($product->vendor_id !== Auth::user()->vendor->id) {
            abort(403);
        }
        return $datatable->render('vendor.product.image-gallery.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request )
    {
        $request->validate([
            'image.*' => ['required', 'image', 'max:2048'],
            'product' => ['required', 'integer']
        ]);
        $response = $this->productRepo->storeImageGallery($request->image, $request->product);
        if($response['status'] == 'success') {
            toastr("images Uploded Succesfully", 'success');
        } else {
            toastr("Error images Uploding");
        }
        return redirect()->back();

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
        $response = $this->productRepo->deleteImageGallery($id);
        return $response['status'] == 'success'
            ? response(['status' => 'success', 'message' => 'Image Deleted Successfully!'])
            : response(['status' => 'error', 'message' => $response['message']]) ;
    }
}

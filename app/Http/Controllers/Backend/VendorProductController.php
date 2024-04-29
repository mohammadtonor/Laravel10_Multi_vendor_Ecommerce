<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\VendorProductDatatable;
use App\Http\Repositories\ProductRepo;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\SubCategory;

class VendorProductController extends Controller
{
    private ProductRepo $productRepo;
    public function __construct(ProductRepo $productRepo) {
        $this->productRepo = $productRepo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(VendorProductDatatable $datatable)
    {
        return $datatable->render('vendor.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('vendor.product.create', compact('categories', 'brands'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'max:3000'],
            'name' => ['required', 'max:200'],
            'category' => ['required'],
            'brand' => ['required'],
            'price' => ['required'],
            'qty' => ['required'],
            'short_description' => ['required', 'max:260'],
            'long_description' => ['required'],
            'product_type' => ['required'],
            'seo_title' => ['nullable', 'max:200'],
            'seo_description' => ['nullable', 'max:250'],
            'status' => ['required'],
        ]);

        $response = $this->productRepo->storeProduct(
            $request->image,
            $request->name,
            $request->category,
            $request->sub_category,
            $request->child_category,
            $request->brand,
            $request->qty,
            $request->video_link,
            $request->short_description,
            $request->long_description,
            $request->sku,
            $request->price ,
            $request->offer_price,
            $request->offer_start_date,
            $request->offer_end_date,
            $request->product_type,
            $request->status,
            $request->seo_title,
            $request->seo_description,
        );

        if($response['status'] == 'success') {
            toastr('Vendor product created successfully');
            return redirect()->route('vendor.products.index');
        } else {
            toastr('Error creating vendor product');
            return redirect()->back();
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
        $vendorProduct = Product::FindOrFail($id);
        if($vendorProduct->vendor_id !== Auth::user()->vendor->id) {
             abort(403);
        }

        $categories = Category::all();
        $subCategories = SubCategory::all();
        $childCategories  = ChildCategory::all();
        $brands = Brand::all();

        return view('vendor.product.edit', compact('categories', 'subCategories', 'childCategories', 'vendorProduct', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'image' => ['nullable', 'image', 'max:3000'],
            'name' => ['required', 'max:200'],
            'category' => ['required'],
            'brand' => ['required'],
            'price' => ['required'],
            'qty' => ['required'],
            'short_description' => ['required', 'max:260'],
            'long_description' => ['required'],
            'product_type' => ['required'],
            'seo_title' => ['nullable', 'max:200'],
            'seo_description' => ['nullable', 'max:250'],
            'status' => ['required'],
        ]);

        $response = $this->productRepo->updateProduct(
            $id,
            $request->image,
            $request->name,
            $request->category,
            $request->sub_category,
            $request->child_category,
            $request->brand,
            $request->qty,
            $request->video_link,
            $request->short_description,
            $request->long_description,
            $request->sku,
            $request->price ,
            $request->offer_price,
            $request->offer_start_date,
            $request->offer_end_date,
            $request->product_type,
            $request->status,
            $request->seo_title,
            $request->seo_description,
        );

        if($response['status'] == 'success') {
            toastr('Vendor product Updated successfully');
            return redirect()->route('vendor.products.index');
        } else {
            toastr('Error creating vendor product');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getSubCategories (Request $request) {
        return $this->productRepo->getSubCategories($request->id);
     }

     public function getChildCategories (Request $request) {
        return $this->productRepo->getChildCategories($request->id);
    }
}

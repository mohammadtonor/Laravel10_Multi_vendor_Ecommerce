<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\DataTables\ProductDatatable;
use App\Models\Brand;
use App\Models\Product;
use App\Http\Repositories\ProductRepo;

use App\Models\ChildCategory;
use App\Models\ProductImageGallery;
use App\Models\ProductVariant;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    private ProductRepo $productRepo;
    public function __construct(ProductRepo $productRepo) {
        $this->productRepo = $productRepo;
    }    /**
     * Display a listing of the resource.
     */
    public function index(ProductDatatable $datatable)
    {
        return $datatable->render('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.product.create', compact('categories', 'brands'));
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
            return redirect()->route('admin.products.index');
        } else {
            toastr('Error creating admin product');
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
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $subCategories = SubCategory::where('category_id', $product->category_id)->get();;
        $childCategories = ChildCategory::where('sub_category_id', $product->sub_category_id)->get();;
        $brands = Brand::all();
        return view('admin.product.edit', compact('product','categories', 'brands', 'childCategories', 'subCategories'));
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
            return redirect()->route('admin.product.index');
        } else {
            toastr('Error Updating vendor product');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->productRepo->deleteProduct($id);
        return $response['status'] == 'success'
            ? response(['status' => 'success', 'message' => 'Deleted Successfully!'])
            : response(['status' => 'error', 'message' => 'Error occured Deleting!']) ;
    }

     /**
     * Get all categories
     */
     public function getSubCategories (Request $request) {
        $subCategories = SubCategory::where('category_id', $request->id)->get();

        return $subCategories;
     }

     public function getChildCategories (Request $request) {
        $childCategories = ChildCategory::where('sub_category_id', $request->id)->get();

        return $childCategories;
     }

     public function changeStatus (Request $request) {
        $response = $this->productRepo->changeProductStatus($request->id, $request->isChecked);
        return $response['status'] == 'success'
            ? response(['status' => 'success', 'message' => 'Status Updated Successfully!'])
            : response(['status' => 'error', 'message' => 'Error occured Updaying!']) ;
    }
}

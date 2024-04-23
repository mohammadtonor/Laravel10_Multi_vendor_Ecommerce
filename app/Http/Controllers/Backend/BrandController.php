<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\BrandDataTable;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(BrandDataTable $datatable)
    {
       return $datatable->render('admin.brand.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'logo' => ['required', 'image', 'max:2048'],
            'name' => ['required', 'max:200', 'unique:brands,name'],
            'is_featured' => ['required'],
            'status' => ['required']
        ]);

        $brand = new Brand();
        
        $imagePath = $this->uploadImage($request, 'logo', 'uploads');
        $brand->logo =  $imagePath;
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $brand->is_featured = $request->is_featured;
        $brand->status = $request->status;

        $brand->save();
        toastr("Brand created successfully", "success");

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
        $brand = Brand::findOrFail($id);
        return view('admin.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'logo' => ['image', 'max:2048'],
            'name' => ['required', 'max:200', 'unique:brands,name,'.$id],
            'is_featured' => ['required'],
            'status' => ['required']
        ]);

        $brand = Brand::findOrFail($id);
        
        $logoPath = $this->uploadImage($request, 'logo', 'uploads');

        $brand->logo =  !empty($logoPath) ? $logoPath : $brand->logo; 
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $brand->is_featured = $request->is_featured;
        $brand->status = $request->status;

        $brand->save();
        toastr("Brand Updated successfully", "success");

        return redirect()->route('admin.brand.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();

        return response(['status' => 'success', 'message' => 'Brand deleted successfully']);
    }

    public function changeStatus (Request $request) {
        $brand = Brand::findOrFail($request->id);
        $brand->status = $request->isChecked == 'true' ? 1 : 0;
        $brand->save();

        return response(['status' => 'success', 'message' => 'Brand updated successfully']);
    }
}

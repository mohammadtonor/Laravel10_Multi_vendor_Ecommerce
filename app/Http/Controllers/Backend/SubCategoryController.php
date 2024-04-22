<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SubCategoryDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SubCategoryDataTable $datatable)
    {
        return $datatable->render('admin.sub-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   $categories = Category::all();
        return view('admin.sub-category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $request->validate([
            'category' => ['required',],
            'name' => ['required', 'max:200' , 'unique:sub_categories,name'],
            'status' => ['required']
        ]);

        $subCategory = new SubCategory();

        $subCategory->category_id = $request->category;
        $subCategory->name = $request->name;
        $subCategory->slug = Str::slug($request->name);
        $subCategory->status = $request->status;
        $subCategory->save();

        toastr("Category Created Successfully", 'success');

        return redirect()->route('admin.sub-category.index');
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
        $subCategory = SubCategory::findOrFail($id);
        $categories = Category::all();
        return view('admin.sub-category.edit', compact('subCategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category' => ['required',],
            'name' => ['required', 'max:200' , 'unique:sub_categories,name,'.$id],
            'status' => ['required']
        ]);

        $subCategory = SubCategory::findOrFail($id);

        $subCategory->category_id = $request->category;
        $subCategory->name = $request->name;
        $subCategory->slug = Str::slug($request->name);
        $subCategory->status = $request->status;
        $subCategory->save();

        toastr("Category Updated Successfully", 'success');

        return redirect()->route('admin.sub-category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $childCategory = ChildCategory::where('sub_category_id', $subCategory->id)->count();
        if($childCategory > 0 ) {
            return response(['status' => 'error', 'message' => 'The item has a childCategory,first deleted childCAtegory related this item!']);
        }
        $subCategory->delete();

        return response(['status' => 'success', 'message' => 'SubCategory deleted successfully']);
    }

    public function changeStatus (Request $request) {
        $subCategory = SubCategory::findOrFail($request->id);
        $subCategory->status = $request->isChecked == 'true' ? 1 : 0;
        $subCategory->save();

        return response(['status' => 'success', 'message' => 'SubCategory updated successfully']);
    }
}

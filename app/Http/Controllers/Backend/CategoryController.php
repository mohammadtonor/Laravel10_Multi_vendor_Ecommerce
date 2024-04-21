<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\CategoryDatatable;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryDatatable $datatable)
    {
        return $datatable->render('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $request->validate([
            'icon' => ['required', 'not_in:empty' ],
            'name' => ['required', 'max:200' , 'unique:categories,name'],
            'status' => ['required']
        ]);

        $category = new Category();

        $category->name = $request->name;
        $category->icon = $request->icon;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status;
        $category->save();

        toastr("Category Created Successfully", 'success');

        return redirect()->route('admin.category.index');
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
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'icon' => ['required', 'not_in:empty' ],
            'name' => ['required', 'max:200', 'unique:categories,name,'.$id],
            'status' => ['required']
        ]);

        $category =  Category::findOrFail($id);

        $category->name = $request->name;
        $category->icon = $request->icon;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status;
        $category->save();

        toastr("Category Updated Successfully", 'success');

        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response(['status' => 'success', 'message' =>'Category Deletet Succesfully!']);
    }

    public function changeStatus(Request $request) {
        $category = Category::findOrFail($request->id);
        $category->status = $request->isChecked == 'true' ? 1 : 0;
        $category->save();

        return response(['status' => 'success', 'message' =>'Category Updated Succesfully!']);
    }
}

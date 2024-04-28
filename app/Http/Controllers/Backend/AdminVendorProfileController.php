<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ImageUploadTrait;

class AdminVendorProfileController extends Controller
{   use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profile = Vendor::where('user_id', Auth::user()->id)->first();
        return view('admin.vendor.index', compact('profile'));
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
    public function store(Request $request)
    {
        $request->validate([
            'banner' => ['nullable', 'image' , 'max:3000'],
            'phone' => ['required' , 'max:50'],
            'email' => ['required', 'max:200', 'email'],
            'address' => ['required'],
            "description" => ['required'],
            'fb_link' => ['nullable', 'url'],
            'wa_link' => ['nullable', 'url'],
            'insta_link' => ['nullable', 'url'],
        ]);

        $vendor = Vendor::where('user_id', Auth::user()->id)->first();
        $bannerPath = $this->uploadImage($request, 'banner', 'uploads' ,$vendor->banner);

        $vendor->banner = !empty($bannerPath) ? $bannerPath : $vendor->banner;
        $vendor->phone = $request->phone;
        $vendor->email = $request->email;
        $vendor->address = $request->address;
        $vendor->description = $request->description;
        $vendor->fb_link = $request->fb_link;
        $vendor->wa_link = $request->wa_link;
        $vendor->insta_link = $request->insta_link;
        $vendor->save();

        toastr('Vendor Profile Updated Successfuly', 'success');

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
        //
    }
}

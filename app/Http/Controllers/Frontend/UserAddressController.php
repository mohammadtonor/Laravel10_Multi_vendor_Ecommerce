<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Repositories\frontend\UserAddressRepo;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAddressController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected UserAddressRepo $userAddressRepo,
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userAddresses = UserAddress::where('user_id', Auth::user()->id)->get();
        return view('frontend.dashboard.adsress.index', compact('userAddresses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('frontend.dashboard.adsress.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:200'],
            'email' => ['required', 'max:200'],
            'phone' => ['required', 'max:200'],
            'country' => ['required', 'max:200'],
            'state' => ['required', 'max:200'],
            'city' => ['required', 'max:200'],
            'zip' => ['required', 'max:200'],
            'address' => ['required', 'max:200'],
        ]);

        $response = $this->userAddressRepo->storeUserAddress(
            $request->name,
            $request->email,
            $request->phone,
            $request->country,
            $request->state,
            $request->city,
            $request->zip,
            $request->address,
        );

        if ($response['status'] == 'success') {
            toastr('Created Succussffuly');
            return redirect()->route('user.address.index');
        } else {
            toastr('Failed  Creating');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $userAddresse = UserAddress::findOrFail($id);
        return view('frontend.dashboard.adsress.edit', compact('userAddresse'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'max:200'],
            'email' => ['required', 'max:200'],
            'phone' => ['required', 'max:200'],
            'country' => ['required', 'max:200'],
            'state' => ['required', 'max:200'],
            'city' => ['required', 'max:200'],
            'zip' => ['required', 'max:200'],
            'address' => ['required', 'max:200'],
        ]);

        $response = $this->userAddressRepo->updateUserAddress(
            $id,
            $request->name,
            $request->email,
            $request->phone,
            $request->country,
            $request->state,
            $request->city,
            $request->zip,
            $request->address,
        );

        if ($response['status'] == 'success') {
            toastr('Updated Succussffuly');
            return redirect()->route('user.address.index');
        } else {
            toastr('Failed  Updating');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->userAddressRepo->deleteUserAddress($id);
        return $response['status'] == 'success'
            ? response(['status' => 'success', 'message' => 'Address Deleted Successfully!'])
            : response(['status' => 'error', 'message' => 'Error occured Deleting!']) ;
    }
}

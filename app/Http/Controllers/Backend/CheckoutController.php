<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ShippingRule;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index() {
        $addresses = UserAddress::where('user_id', Auth::user()->id)->get();
        $shippingRule = ShippingRule::where('status', 1)->get();
        return view('frontend.pages.checkout', compact('addresses', 'shippingRule'));
    }

    public function storeAddress(Request $request) {
        $request->validate([
            'name' => ['required', 'max:200'],
            'phone' => ['required', 'max:200'],
            'email' => ['required', 'email'],
            'country' => ['required', 'max:200'],
            'state' => ['required', 'max:200'],
            'city' => ['required', 'max:200'],
            'zip' => ['required', 'max:200'],
            'address' => ['required', 'max:200'],
        ]);

        $userAddress = new UserAddress();

        $userAddress->user_id = Auth::user()->id;
        $userAddress->name = $request->name;
        $userAddress->phone = $request->phone;
        $userAddress->email = $request->email;
        $userAddress->country = $request->country;
        $userAddress->state = $request->state;
        $userAddress->city = $request->city;
        $userAddress->zip = $request->zip;
        $userAddress->address = $request->address;

        $userAddress->save();

        toastr('Address Created Successfully');
        return redirect()->back();
    }

    public function checkoutFormSubmit(Request $request) {
        $request->validate([
            'shipping_method_id' => ['required'],
            'shipping_address_id' => ['required'],
        ]);

        $shippingMethod = ShippingRule::findOrFail($request->shipping_method_id);
        if ($shippingMethod) {
            Session::put('shipping_method', [
                'id' => $shippingMethod->id,
                'name' => $shippingMethod->name,
                'type' => $shippingMethod->type,
                'cost' => $shippingMethod->cost,
            ]);
        }

        $address = UserAddress::findOrFail($request->shipping_address_id)->toArray();
        if($address) {
            Session::put('shipping_address', $address);
        }

        return response(['status' => 'success', 'redirect_url' => route('user.payment')]);
    }
}

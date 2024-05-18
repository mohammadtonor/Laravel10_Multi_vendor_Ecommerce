<?php

namespace App\Http\Repositories\frontend;

use App\Models\UserAddress;
use Exception;
use Illuminate\Support\Facades\Auth;

class UserAddressRepo
{

    public function storeUserAddress(
        $name,
        $email,
        $phone,
        $country,
        $state,
        $city,
        $zip,
        $address,
    ) {

        $userAddress = new UserAddress();

        $userAddress->user_id = Auth::user()->id;
        $userAddress->name = $name;
        $userAddress->email = $email;
        $userAddress->phone = $phone;
        $userAddress->country = $country;
        $userAddress->state = $state;
        $userAddress->city = $city;
        $userAddress->zip = $zip;
        $userAddress->address = $address;


        return  $userAddress->save() ?
                ["status" => "success", "result" => $userAddress] :
                ["status" => "failed"];
    }

    public function updateUserAddress(
        $id,
        $name,
        $email,
        $phone,
        $country,
        $state,
        $city,
        $zip,
        $address,
    ) {

        $userAddress =  UserAddress::findOrFail($id);

        $userAddress->name = $name;
        $userAddress->email = $email;
        $userAddress->phone = $phone;
        $userAddress->country = $country;
        $userAddress->state = $state;
        $userAddress->city = $city;
        $userAddress->zip = $zip;
        $userAddress->address = $address;

        return  $userAddress->save() ?
                ["status" => "success", "result" => $userAddress] :
                ["status" => "failed"];
    }

    public function deleteUserAddress($id) {
        try {
            $userAddress = UserAddress::findOrFail($id);
            $userAddress->delete();
            return ['status' =>'success'];
        } catch (Exception  $error) {
            return ["status" => "failed" ];
        }
    }

}

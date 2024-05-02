<?php

namespace App\Http\Repositories;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Traits\ImageUploadTrait;
use App\Models\ProductImageGallery;
use Illuminate\Support\Str;
use Exception;

class CouponRepo
{
    use ImageUploadTrait;

    public function storeCoupon(
        $name,
        $code,
        $quantity,
        $max_use,
        $start_date,
        $end_date,
        $discount_type,
        $discount,
        $status,
    ) {

        $coupon = new Coupon();

        $coupon->name = $name;
        $coupon->code = $code;
        $coupon->quantity = $quantity;
        $coupon->max_use = $max_use;
        $coupon->start_date = $start_date;
        $coupon->end_date = $end_date;
        $coupon->discount_type = $discount_type;
        $coupon->discount = $discount;
        $coupon->total_used = 0;
        $coupon->status = $status;


        return  $coupon->save() ?
                ["status" => "success", "result" => $coupon] :
                ["status" => "failed"];
    }

    public function updateCoupon(
        $id,
        $name,
        $code,
        $quantity,
        $max_use,
        $start_date,
        $end_date,
        $discount_type,
        $discount,
        $status,
    ) {

        $coupon =  Coupon::findOrFail($id);

        $coupon->name = $name;
        $coupon->code = $code;
        $coupon->quantity = $quantity;
        $coupon->max_use = $max_use;
        $coupon->start_date = $start_date;
        $coupon->end_date = $end_date;
        $coupon->discount_type = $discount_type;
        $coupon->discount = $discount;
        $coupon->status = $status;


        return  $coupon->save() ?
                ["status" => "success", "result" => $coupon] :
                ["status" => "failed"];
    }

    public function deleteCoupon($id) {
        try {
            $coupon = Coupon::findOrFail($id);

            $coupon->delete();
            return ['status' =>'success'];
        } catch (Exception  $error) {
            return ["status" => "failed" ];
        }
    }

    public function changeCouponStatus ($id, $isChecked) {
        try {
            $coupon = Coupon::findOrFail($id);
            $coupon->status = $isChecked == 'true' ? 1 : 0;
            $coupon->save();
            return ["status" => "success"];
        } catch (Exception  $error) {
            return ["status" => "failed" , 'error' => $error];
        }
    }

}

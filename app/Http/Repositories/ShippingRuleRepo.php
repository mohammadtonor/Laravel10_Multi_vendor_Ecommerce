<?php

namespace App\Http\Repositories;

use App\Traits\ImageUploadTrait;
use App\Models\ShippingRule;
use Exception;

class ShippingRuleRepo
{

    public function storeShippingRule(
        $name,
        $type,
        $cost,
        $min_cost,
        $status,
    ) {

        $shippingRule = new ShippingRule();

        $shippingRule->name = $name;
        $shippingRule->type = $type;
        $shippingRule->cost = $cost;
        $shippingRule->min_cost = $min_cost;
        $shippingRule->status = $status;


        return  $shippingRule->save() ?
                ["status" => "success", "result" => $shippingRule] :
                ["status" => "failed"];
    }

    public function updateShippingRule(
        $id,
        $name,
        $type,
        $cost,
        $min_cost,
        $status,
    ) {

        $shippingRule =  ShippingRule::findOrFail($id);

        $shippingRule->name = $name;
        $shippingRule->type = $type;
        $shippingRule->cost = $cost;
        $shippingRule->min_cost = $type == 'min_cost' ?  $min_cost : 0;
        $shippingRule->status = $status;

        return  $shippingRule->save() ?
                ["status" => "success", "result" => $shippingRule] :
                ["status" => "failed"];
    }

    public function deleteShippingRule($id) {
        try {
            $shippingRule = ShippingRule::findOrFail($id);

            $shippingRule->delete();
            return ['status' =>'success'];
        } catch (Exception  $error) {
            return ["status" => "failed" ];
        }
    }

    public function changeShippingRuleStatus ($id, $isChecked) {
        try {
            $shippingRule = ShippingRule::findOrFail($id);
            $shippingRule->status = $isChecked == 'true' ? 1 : 0;
            $shippingRule->save();
            return ["status" => "success"];
        } catch (Exception  $error) {
            return ["status" => "failed" , 'error' => $error];
        }
    }

}

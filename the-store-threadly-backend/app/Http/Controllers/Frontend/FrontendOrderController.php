<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveryResource;
use App\Models\Coupon;
use App\Models\DeliveryMethod;
use Illuminate\Http\Request;

class FrontendOrderController extends Controller
{
    public function coupon (Request $request) 
    {
        $request->validate([
            "code" => "required|string|exists:coupons,code",
            "cart_sub_total" => "required|numeric",
        ]);

        $coupon = Coupon::where("code",$request->code)->first();

        if(!$coupon || $coupon->status == 0)
            return response()->json(["message" => "Invalid or inactive coupon."], 400);

        if($coupon->quantity < 1)
            return response()->json(["message" => "Coupon has been fully redeemed."], 400);

        if($request->cart_sub_total < $coupon->min_purchase_amount)
            return response()->json(["message" => "Minimum purchase amount not met."], 400);

        if(date('Y-m-d') > $coupon->expire_date)
            return response()->json(["message" => "Coupon has expired."],);

        $discount = 0;
        $code = 0;

        if ($coupon->discount_type === "percent") {
            $discount = ($coupon->discount / 100) * $request->cart_sub_total;
        } else {
            $discount = $coupon->discount;
        }

        $coupon->decrement("quantity");

        return response()->json([
            "message"=>"Coupon successfully aplied.",
            "data" => [
                "code" => $coupon->code,
                "discount" => $coupon->getDiscount(),
                "discountRaw" => number_format($discount, 2),
            ]
        ],200);
    }

    public function fetch_delivery () {
        $deliveries = DeliveryMethod::
            orderBy("id","DESC")->
            where("status",true)->
            get();

        return response()->json([
            "message"=>"Delivery methods retrieved successfully.",
            "data" => DeliveryResource::collection($deliveries)
        ],200);
    }
}

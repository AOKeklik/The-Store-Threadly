<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminCouponController extends Controller
{
    public function index ():View {
        $coupons=Coupon::orderBy("id","DESC")->get();
        return view("admin.coupon.index",compact("coupons"));
    }
    public function coupon_section_table_view() :View
    {
        $coupons=Coupon::orderBy("id","desc")->get();
        return view("admin.coupon.table",compact("coupons"));
    }
    public function coupon_edit_view ($coupon_id) 
    {
        $coupons=Coupon::orderBy("id","DESC")->get();
        $coupon=Coupon::find($coupon_id);

        if(!$coupon)
	        return redirect()->route("admin.coupon.view")->with("error","The coupon not found.");

        return view("admin.coupon.edit",compact("coupon","coupons"));
    }

    public function coupon_store(Request $request) 
    {
        try{
            $validator = \Validator::make($request->all(),[
                "name"=>"required|string|unique:coupons,name",
                "code"=>"required|string|unique:coupons,code|min:6|max:15",
                "quantity"=>"nullable|numeric",
                "min_purchase_amount"=>"nullable|numeric",
                "expire_date"=>"nullable|date",
                "discount_type"=>"required|string|in:percent,amount",
                "discount"=>"required|numeric",
            ]);

            if(!$validator->passes())
                return response()->json(["message"=>$validator->errors()->toArray()],422);
    
            $coupon=new Coupon();
            $coupon->name=$request->name;
            $coupon->code=$request->code;
            $coupon->quantity=$request->quantity;
            $coupon->expire_date=$request->expire_date;
            $coupon->min_purchase_amount=$request->min_purchase_amount;
            $coupon->discount_type=$request->discount_type;
            $coupon->discount=$request->discount;
        
            if(!$coupon->save())
                throw new \Exception("Failed to save coupon."); 
    
            return response()->json(["message"=>"Coupon added successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function coupon_update(Request $request) 
    {
        try{
            $validator = \Validator::make($request->all(),[
                "name" => [
                    "required",
                    "string",
                    Rule::unique("coupons","name")->ignore($request->id)
                ],
                "code" => [
                    "required",
                    "string",
                    Rule::unique("coupons","code")->ignore($request->id)
                ],
                "quantity"=>"nullable|numeric",
                "min_purchase_amount"=>"nullable|numeric",
                "expire_date"=>"nullable|date",
                "discount_type"=>"required|string|in:percent,amount",
                "discount"=>"required|numeric",
            ]);

            if(!$validator->passes())
                return response()->json(["message"=>$validator->errors()->toArray()],422);
    
            $coupon=Coupon::find($request->id);
    
            if(!$coupon)
                throw new \Exception("Coupon not found.");

            $coupon->name=$request->name;
            $coupon->code=$request->code;
            $coupon->quantity=$request->quantity;
            $coupon->expire_date=$request->expire_date;
            $coupon->min_purchase_amount=$request->min_purchase_amount;
            $coupon->discount_type=$request->discount_type;
            $coupon->discount=$request->discount;
        
            if(!$coupon->save())
                throw new \Exception("Failed to save coupon."); 
    
            return response()->json(["message"=>"Coupon updated successfully.","redirect"=>route("admin.coupon.view")],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function coupon_status_update(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(),[
                "status"=>"nullable|string|in:1,0",
            ]);

            if($validator->fails())
                throw new \Exception($validator->errors()->first());
    
            $coupon=Coupon::find($request->id);
    
            if(!$coupon)
                throw new \Exception("Coupon not found.");

            $coupon->status=$request->status;
        
            if(!$coupon->save())
                throw new \Exception("Failed to save status."); 
    
            return response()->json(["message"=>"Status updated successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function coupon_delete(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(), [
                "id"=>"required|numeric|exists:coupons,id",
            ]);
    
            if($validator->fails())
                throw new \Exception($validator->errors()->first());
    
            $coupon=Coupon::find($request->id);
    
            if(!$coupon)
                throw new \Exception("Coupon not found.");

            if(!$coupon->delete())
                throw new \Exception("Failed to delete the coupon.");
    
            return response()->json(["message"=>"The coupon deleted successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
}

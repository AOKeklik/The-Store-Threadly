<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryMethod;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminDeliveryController extends Controller
{
    public function index() :View
    {
        $deliveries= DeliveryMethod::
            orderBy("id", "DESC")
            ->get();

        return view("admin.delivery.index",compact("deliveries"));
    }
    public function section_table_view() :View
    {
        $deliveries= DeliveryMethod::
            orderBy("id", "DESC")
            ->get();

        return view("admin.delivery.table",compact("deliveries"));
    }
    public function edit_view($id)
    {
        $delivery=DeliveryMethod::find($id);

        if(!$delivery)
            return redirect()->route("admin.delivery.view")->with("error","The delivery not found.");

        return view("admin.delivery.edit",compact("delivery"));
    }


    public function store(Request $request) 
    {
        try{
            $validator = \Validator::make($request->all(),[
                "name"=>"required|string|unique:categories,name",
                "company"=>"nullable|string|max:255",
                "desc"=>"nullable|string|max:1000",
                "price"=>"required|numeric",
                "type"=>"required|string|in:courier,post,locker,pickup_point",
            ]);

            if(!$validator->passes())
                return response()->json(["message"=>$validator->errors()->toArray()],422);
    
            DeliveryMethod::create([
                "name" => $request->name,
                "company" => $request->company,
                "desc" => $request->desc,
                "price" => $request->price,
                "type" => $request->type,
            ]);
    
            return response()->json(["message"=>"Category added successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function update(Request $request) 
    {
        try{
            $validator = \Validator::make($request->all(),[
                "name"=>[
                    "required",
                    "string",
                    Rule::unique("categories","name")->ignore($request->id)
                ],
                "company"=>"nullable|string|max:255",
                "desc"=>"nullable|string|max:1000",
                "price"=>"required|numeric",
                "type"=>"required|string|in:courier,post,locker,pickup_point",
            ]);

            if(!$validator->passes())
                return response()->json(["message"=>$validator->errors()->toArray()],422);
    
            $delivery=DeliveryMethod::find($request->id);

            if(!$delivery)
                throw new \Exception("Delivery not found.");

            $delivery->update([
                "name" => $request->name,
                "company" => $request->company,
                "desc" => $request->desc,
                "price" => $request->price,
                "type" => $request->type,
            ]);
    
            return response()->json(["message"=>"Delivery updated successfully.","redirect"=>route("admin.delivery.view")],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function status_update(Request $request)
    {
        try{
            $validated = \Validator::make($request->all(),[
                "status_key" => "required|string|in:status,code",
                "status_value" => "required|boolean",
            ]);

            if($validated->fails())
            // if(!$validator->passes())
                throw new \Exception($validated->errors()->first());
    
            $product=DeliveryMethod::find($request->id);
    
            if(!$product)
                throw new \Exception("Delivery not found.");
        
            if(!$product->update([
                $request->status_key => $request->status_value
            ]))
                throw new \Exception("Failed to save status."); 
    
            return response()->json(["message"=>"Status updated successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function delete(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(), [
                "id" => "required|numeric|exists:delivery_methods,id",
            ]);
    
            if($validator->fails())
                throw new \Exception($validator->errors()->first());
    
            $delivery=DeliveryMethod::find($request->id);
    
            if(!$delivery)
                throw new \Exception("Delivery not found.");

            if(!$delivery->delete())
                throw new \Exception("Failed to delete the delivery.");
    
            return response()->json(["message"=>"The delivery deleted successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
}

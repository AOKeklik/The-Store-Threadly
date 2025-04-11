<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Variant;
use App\Services\ImageService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminProductVariantController extends Controller
{
    public function index($product_id)
    {
        $attributes = Attribute::
            orderBy('id', 'asc')
            ->get();

        $variants=Variant::
            where("product_id",$product_id)->
            orderBy("id","desc")->
            get();

        return view("admin.product-variant.index",compact("variants","attributes"));
    }
    public function product_variant_section_table_view($product_id) :View
    {
        $variants=Variant::
            where("product_id",$product_id)->
            orderBy("id","desc")->
            get();

        return view("admin.product-variant.table",compact("variants"));
    }
    public function product_variant_edit_view($id)
    {
        $attributes = Attribute::
            orderBy('id', 'asc')
            ->get();

        $variant=Variant::find($id);

        if(!$variant)
            return redirect()->route("admin.product.view")->with("error","The variant not found.");

        return view("admin.product-variant.edit",compact("variant","attributes"));
    }



    public function product_variant_store (Request $request,ImageService $imageService) 
    {
        try{
            // return response()->json($request->all(),500);
            $validator = \Validator::make($request->all(),[
                "product_id"=>"nullable|numeric|exists:products,id",
                "attributes.*"=>"nullable|numeric|min:1|exists:attribute_values,id",
                "image"=>"required|file|mimes:jpg,jpeg,png|max:1048576",
                "price"=>"required|numeric",
                "offer_price"=>"nullable|numeric",
                "stock"=>"nullable|numeric",
            ]);

            if(!$validator->passes())
                return response()->json(["message"=>$validator->errors()->toArray()],422);

            $selected = array_filter($request->input("attributes"), fn($v) => !is_null($v) && $v !== '');
                if (count($selected) < 1) {
                    return response()->json(['message' => ["attributes"=>['You must select at least one attribute.']]], 422);
                }
    
            $variant=new Variant();
            $image = $imageService->uploadPhoto($request,null,"variant");

            $variant->product_id=$request->product_id;
            $variant->attribute_value_ids=$request->input('attributes');
            $variant->image=$image;
            $variant->price=$request->price;
            $variant->offer_price=$request->offer_price;
            $variant->stock=$request->stock;
        
            if(!$variant->save())
                throw new \Exception("Failed to save variant."); 
    
            return response()->json(["message"=>"Variant added successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function product_variant_update (Request $request,ImageService $imageService) 
    {
        try{
            // return response()->json($request->all(),500);
            $validator = \Validator::make($request->all(),[
                "attributes.*"=>"nullable|numeric|min:1|exists:attribute_values,id",
                "image"=>"nullable|file|mimes:jpg,jpeg,png|max:1048576",
                "price"=>"required|numeric",
                "offer_price"=>"nullable|numeric",
                "stock"=>"nullable|numeric",
            ]);

            if(!$validator->passes())
                return response()->json(["message"=>$validator->errors()->toArray()],422);

            $selected = array_filter($request->input("attributes"), fn($v) => !is_null($v) && $v !== '');
                if (count($selected) < 1) {
                    return response()->json(['message' => ["attributes"=>['You must select at least one attribute.']]], 422);
                }
    
            $variant=Variant::find($request->id);

            if(!$variant)
	            throw new \Exception("Variant not found.");

            $image = $imageService->uploadPhoto($request,$variant,"variant");

            $variant->attribute_value_ids=$request->input('attributes');
            $variant->image=$image;
            $variant->price=$request->price;
            $variant->offer_price=$request->offer_price;
            $variant->stock=$request->stock;
        
            if(!$variant->save())
                throw new \Exception("Failed to save variant."); 
    
            return response()->json(["message"=>"Variant updated successfully.","redirect"=>route("admin.product.variant.view",$variant->product_id)],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function product_variant_status_update(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(),[
                "status"=>"nullable|string|in:1,0",
            ]);

            if($validator->fails())
                throw new \Exception($validator->errors()->first());
    
            $variant=Variant::find($request->id);
    
            if(!$variant)
                throw new \Exception("Variant not found.");

            $variant->status=$request->status;
        
            if(!$variant->save())
                throw new \Exception("Failed to save status."); 
    
            return response()->json(["message"=>"Status updated successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function product_variant_delete(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(), [
                "id"=>"required|numeric|exists:variants,id",
            ]);
    
            if($validator->fails())
                throw new \Exception($validator->errors()->first());
    
            $variant=Variant::find($request->id);
    
            if(!$variant)
                throw new \Exception("Variant not found.");

            $productImage=public_path("uploads/variant/").$variant->image;
            if($variant->image && file_exists($productImage))
                unlink($productImage);
                
            if(!$variant->delete())
                throw new \Exception("Failed to delete the variant.");
    
            return response()->json(["message"=>"The coupon deleted successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
}

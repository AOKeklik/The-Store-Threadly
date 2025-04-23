<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use App\Models\VariantGalery;
use App\Services\ImageService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminVariantGaleryController extends Controller
{
    public function index($variant_id)
    {
        $variant=ProductVariant::find($variant_id);

        if(!$variant)
            throw new \Exception("Variant not found.");

        $variantGaleries=VariantGalery::
            where("product_variant_id",$variant_id)->
            orderBy("id","desc")->
            get();

        return view("admin.variant-galery.index",compact("variant","variantGaleries"));
    }
    public function variant_galery_section_table_view($variant_id) :View
    {
        $variantGaleries=VariantGalery::
            where("product_variant_id",$variant_id)->
            orderBy("id","desc")->
            get();

        return view("admin.variant-galery.table",compact("variantGaleries"));
    }
    public function variant_galery_edit_view($id)
    {
        $variantGalery=VariantGalery::find($id);

        if(!$variantGalery)
            return redirect()->route("admin.product.variant.view")->with("error","The galery not found.");

        return view("admin.variant-galery.edit",compact("variantGalery"));
    }


    public function variant_galery_store (Request $request,ImageService $imageService) 
    {
        try{
            $validator = \Validator::make($request->all(),[
                "image"=>"required|file|mimes:jpg,jpeg,png|max:1048576",
                "caption"=>"nullable|string",
            ]);

            if(!$validator->passes())
                return response()->json(["message"=>$validator->errors()->toArray()],422);

            $productVariant=ProductVariant::find($request->product_variant_id);

            if(!$productVariant)
                throw new \Exception("Product Variant not found.");
    
            $variantGalery=new VariantGalery();
            $image = $imageService->uploadPhoto($request,null,"variant-galery");

            $variantGalery->product_variant_id=$request->product_variant_id;
            $variantGalery->image=$image;
            $variantGalery->caption=$request->caption;
        
            if(!$variantGalery->save())
                throw new \Exception("Failed to save galery."); 
    
            return response()->json(["message"=>"Galery added successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function variant_galery_update (Request $request,ImageService $imageService) 
    {
        try{
            $validator = \Validator::make($request->all(),[
                "image"=>"nullable|file|mimes:jpg,jpeg,png|max:1048576",
                "caption"=>"nullable|string",
            ]);

            if(!$validator->passes())
                return response()->json(["message"=>$validator->errors()->toArray()],422);

            $variantGalery=VariantGalery::find($request->id);

            if(!$variantGalery)
                throw new \Exception("Galery not found.");
    
            $image = $imageService->uploadPhoto($request,$variantGalery,"variant-galery");

            $variantGalery->image=$image;
            $variantGalery->caption=$request->caption;
        
            if(!$variantGalery->save())
                throw new \Exception("Failed to save galery."); 
    
            return response()->json(["message"=>"Galery updated successfully.","redirect"=>route("admin.product.variant.galery.view", $variantGalery->product_variant_id)],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function variant_galery_status_update(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(),[
                "status"=>"nullable|string|in:1,0",
            ]);

            if($validator->fails())
                throw new \Exception($validator->errors()->first());
    
            $variantGalery=VariantGalery::find($request->id);
    
            if(!$variantGalery)
                throw new \Exception("Galery not found.");

            $variantGalery->status=$request->status;
        
            if(!$variantGalery->save())
                throw new \Exception("Failed to save status."); 
    
            return response()->json(["message"=>"Status updated successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function variant_galery_delete(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(), [
                "id"=>"required|numeric|exists:variant_galeries,id",
            ]);
    
            if($validator->fails())
                throw new \Exception($validator->errors()->first());
    
            $variantGalery=VariantGalery::find($request->id);
    
            if(!$variantGalery)
                throw new \Exception("Product not found.");

            $galeryImage=public_path("uploads/variant-galery/").$variantGalery->image;
            if($variantGalery->image && file_exists($galeryImage))
                unlink($galeryImage);

            if(!$variantGalery->delete())
                throw new \Exception("Failed to delete the galery.");
    
            return response()->json(["message"=>"The galery deleted successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
}

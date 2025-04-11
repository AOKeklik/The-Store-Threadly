<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductGalery;
use App\Services\ImageService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminProductGaleryController extends Controller
{
    public function index($product_id)
    {
        $galeries=ProductGalery::
            where("product_id",$product_id)->
            orderBy("id","desc")->
            get();

        return view("admin.product-galery.index",compact("galeries"));
    }
    public function product_galery_section_table_view($product_id) :View
    {
        $galeries=ProductGalery::
            where("product_id",$product_id)->
            orderBy("id","desc")->
            get();

        return view("admin.product-galery.table",compact("galeries"));
    }
    public function product_galery_edit_view($id)
	    {
	        $galery=ProductGalery::find($id);

	        if(!$galery)
	            return redirect()->route("admin.product.view")->with("error","The galery not found.");

	        return view("admin.product-galery.edit",compact("galery"));
	    }


    public function product_galery_store (Request $request,ImageService $imageService) 
    {
        try{
            $validator = \Validator::make($request->all(),[
                "image"=>"required|file|mimes:jpg,jpeg,png|max:1048576",
                "caption"=>"nullable|string",
            ]);

            if(!$validator->passes())
                return response()->json(["message"=>$validator->errors()->toArray()],422);

            $product=Product::find($request->product_id);

            if(!$product)
                throw new \Exception("Product not found.");
    
            $galery=new ProductGalery();
            $image = $imageService->uploadPhoto($request,null,"galery");

            $galery->product_id=$request->product_id;
            $galery->image=$image;
            $galery->caption=$request->caption;
        
            if(!$galery->save())
                throw new \Exception("Failed to save galery."); 
    
            return response()->json(["message"=>"Galery added successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function product_galery_update (Request $request,ImageService $imageService) 
    {
        try{
            $validator = \Validator::make($request->all(),[
                "image"=>"nullable|file|mimes:jpg,jpeg,png|max:1048576",
                "caption"=>"nullable|string",
            ]);

            if(!$validator->passes())
                return response()->json(["message"=>$validator->errors()->toArray()],422);

            $galery=ProductGalery::find($request->id);

            if(!$galery)
                throw new \Exception("Galery not found.");
    
            $image = $imageService->uploadPhoto($request,$galery,"galery");

            $galery->image=$image;
            $galery->caption=$request->caption;
        
            if(!$galery->save())
                throw new \Exception("Failed to save galery."); 
    
            return response()->json(["message"=>"Galery updated successfully.","redirect"=>route("admin.product.galery.view", $galery->product_id)],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function product_galery_status_update(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(),[
                "status"=>"nullable|string|in:1,0",
            ]);

            if($validator->fails())
                throw new \Exception($validator->errors()->first());
    
            $galery=ProductGalery::find($request->id);
    
            if(!$galery)
                throw new \Exception("Galery not found.");

            $galery->status=$request->status;
        
            if(!$galery->save())
                throw new \Exception("Failed to save status."); 
    
            return response()->json(["message"=>"Status updated successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function product_galery_delete(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(), [
                "id"=>"required|numeric|exists:product_galeries,id",
            ]);
    
            if($validator->fails())
                throw new \Exception($validator->errors()->first());
    
            $galery=ProductGalery::find($request->id);
    
            if(!$galery)
                throw new \Exception("Product not found.");

            if($galery->image && file_exists(public_path("uploads/galery/").$galery->image))
                unlink(public_path("uploads/galery/").$galery->image);

            if(!$galery->delete())
                throw new \Exception("Failed to delete the galery.");
    
            return response()->json(["message"=>"The galery deleted successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
}

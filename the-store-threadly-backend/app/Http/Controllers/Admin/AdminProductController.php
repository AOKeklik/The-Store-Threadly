<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductGalery;
use App\Models\ProductVariant;
use App\Models\Variant;
use App\Services\ImageService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index() :View
    {
        $products=Product::orderBy("id","desc")->get();
        return view("admin.product.index",compact("products"));
    }
    public function product_section_table_view() :View
    {
        $products=Product::orderBy("id","desc")->get();
        return view("admin.product.table",compact("products"));
    }
    public function product_add_view()
    {
        $categories=Category::
            with('parent')
            ->whereHas('parent', function ($query) {
                $query->where('slug', 'product');
            })
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->get();

        if($categories->isEmpty())
            return redirect()->route("admin.product.view")->with("error","Please create at least one category before creating a product.");

        return view("admin.product.add",compact("categories"));
    }
    public function product_edit_view($id)
    {
        $product=Product::find($id);
        $categories=Category::
            with('parent')
            ->whereHas('parent', function ($query) {
                $query->where('slug', 'product');
            })
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->get();

        if(!$product)
            return redirect()->route("admin.product.view")->with("error","The product not found.");

        if($categories->isEmpty())
            return redirect()->route("admin.product.view")->with("error","Please create at least one category before editing a product.");

        return view("admin.product.edit",compact("product","categories"));
    }


    public function product_store (Request $request,ImageService $imageService) 
    {
        try{
            $validator = \Validator::make($request->all(),[
	            "category_id"=>"required|numeric|exists:categories,id",
	            "gender"=>"required|string|in:men,women,kids",
	            "sku"=>"nullable|string",
	            "image"=>"nullable|file|mimes:jpg,jpeg,png|max:1048576",
	            "cover"=>"nullable|file|mimes:jpg,jpeg,png|max:1048576",
	            "title"=>"required|string",
	            "desc"=>"nullable|string",
	            "short_desc"=>"nullable|string",
	            "seo_title"=>"nullable|string",
	            "seo_desc"=>"nullable|string|",
	            "price"=>"required|numeric",
	            "offer_price"=>"nullable|numeric",
	            "stock"=>"nullable|numeric",
            ]);

            if(!$validator->passes())
                return response()->json(["message"=>$validator->errors()->toArray()],422);
    
            $product=new Product();
            $image = $imageService->uploadPhoto($request,null,"product");
            $cover = $imageService->uploadCover($request,null,"product-cover");

            $product->category_id=$request->category_id;
            $product->gender=$request->gender;
            $product->image=$image;
            $product->cover=$cover;
            $product->title=$request->title;
            $product->desc=$request->desc;
            $product->short_desc=$request->short_desc;
            $product->seo_title=$request->seo_title;
            $product->seo_desc=$request->seo_desc;
            $product->price=$request->price;
            $product->offer_price=$request->offer_price;
            $product->stock=$request->stock;
        
            if(!$product->save())
                throw new \Exception("Failed to save product."); 
    
            return response()->json(["message"=>"Product added successfully.","redirect"=>route("admin.product.view")],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function product_update (Request $request,ImageService $imageService) 
    {
        try{
            $validator = \Validator::make($request->all(),[
	            "id"=>"required|numeric|exists:products,id",
	            "category_id"=>"required|numeric|exists:categories,id",
	            "sku"=>"nullable|string",
	            "image"=>"nullable|file|mimes:jpg,jpeg,png|max:1048576",
	            "cover"=>"nullable|file|mimes:jpg,jpeg,png|max:1048576",
	            "title"=>"required|string",
	            "desc"=>"nullable|string",
                "short_desc"=>"nullable|string",
	            "seo_title"=>"nullable|string",
	            "seo_desc"=>"nullable|string|",
	            "price"=>"required|numeric",
	            "offer_price"=>"nullable|numeric",
	            "stock"=>"nullable|numeric",
            ]);

            if(!$validator->passes())
                return response()->json(["message"=>$validator->errors()->toArray()],422);
    
            $product=Product::find($request->id);

            if(!$product)
                throw new \Exception("Product not found.");

            $image = $imageService->uploadPhoto($request,$product,"product");
            $cover = $imageService->uploadCover($request,$product,"product-cover");

            $product->category_id=$request->category_id;
            $product->image=$image;
            $product->cover=$cover;
            $product->title=$request->title;
            $product->desc=$request->desc;
            $product->short_desc=$request->short_desc;
            $product->seo_title=$request->seo_title;
            $product->seo_desc=$request->seo_desc;
            $product->price=$request->price;
            $product->offer_price=$request->offer_price;
            $product->stock=$request->stock;
        
            if(!$product->save())
                throw new \Exception("Failed to save product."); 
    
            return response()->json(["message"=>"Product updated successfully.","redirect"=>route("admin.product.view")],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function product_status_update(Request $request)
    {
        try{
            $validated = \Validator::make($request->all(),[
                'status_type' => 'required|string|in:status,is_new,is_featured,is_bestseller',
                'status_value' => 'required|boolean'
            ]);

            if($validated->fails())
                throw new \Exception($validated->errors()->first());
    
            $product=Product::find($request->id);
    
            if(!$product)
                throw new \Exception("Product not found.");
        
            if(!$product->update([
                $request->status_type => $request->status_value
            ]))
                throw new \Exception("Failed to save status."); 
    
            return response()->json(["message"=>"Status updated successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function product_delete(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(), [
                "id"=>"required|numeric|exists:products,id",
            ]);
    
            if($validator->fails())
                throw new \Exception($validator->errors()->first());
    
            $product=Product::find($request->id);
    
            if(!$product)
                throw new \Exception("Product not found.");

            $productImage=public_path("uploads/product/").$product->image;
            if($product->image && file_exists($productImage))
                unlink($productImage);

            $productCover=public_path("uploads/product/").$product->cover;
            if($product->cover && file_exists($productCover))
                unlink($productCover);

            $galeries=ProductGalery::where("product_id",$request->id)->get();

            foreach($galeries as $galery) {
                $galeryImage=public_path("uploads/galery/").$galery->image;

                if($galery->image && file_exists($galeryImage))
                    unlink($galeryImage);

                if(!$galery->delete())
                    throw new \Exception("Failed to delete the product.");
            }

            $variants=ProductVariant::where("product_id",$request->id)->get();

            foreach($variants as $variant) {
                $variantImage=public_path("uploads/variant/").$variant->image;

                if($variant->image && file_exists($variantImage))
                    unlink($variantImage);

                if(!$variant->delete())
                    throw new \Exception("Failed to delete the product.");
            }
               
            if(!$product->delete())
                throw new \Exception("Failed to delete the product.");
    
            return response()->json(["message"=>"The coupon deleted successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
}

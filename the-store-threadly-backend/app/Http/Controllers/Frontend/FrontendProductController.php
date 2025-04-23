<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class FrontendProductController extends Controller
{
    public function get_all () 
    {
        try{
            $products=Product::
                with(['galeries','variants'])->
                where('status',1)->
                inRandomOrder()->
                get();
            
            return response()->json([
                "message"=>"Products retrieved successfully.",
                "data"=>ProductResource::collection($products),
            ],200);
        }catch(\Exception $err) {
            return response()->json(["message"=>$err->getMessage()], 500);
        }
    }
    public function get_all_by_new () 
    {
        try{
            $products=Product::
                with('galeries','variants')->
                where('status',1)->
                where('is_new',1)->
                inRandomOrder()->
                get()->
                take(12);
            
            return response()->json([
                "message"=>"Products retrieved successfully.",
                "data"=>ProductResource::collection($products),
            ],200);
        }catch(\Exception $err) {
            return response()->json(["message"=>$err->getMessage()], 500);
        }
    }
    public function get_all_by_featured () 
    {
        try{
            $products=Product::
                with('galeries','variants')->
                where('status',1)->
                where('is_featured',1)->
                inRandomOrder()->
                get()->
                take(12);
            
            return response()->json([
                "message"=>"Products retrieved successfully.",
                "data"=>ProductResource::collection($products),
            ],200);
        }catch(\Exception $err) {
            return response()->json(["message"=>$err->getMessage()], 500);
        }
    }
    public function get_one_by_slug ($slug) 
    {
        try{
            $product= Product::
                with([
                    'galeries'=>function($query){
                        $query->where('status',1);
                    },
                    'variants'=>function($query){
                        $query->where('status',1);
                    },
                    'variants.galeries'=>function($query){
                        $query->where('status',1);
                    }
                ])->
                where("status",1)->
                where('slug', $slug)->
                firstOrFail();

            $relatedProducts = Product::
                with(['galeries', 'variants'])->
                where('status', 1)->
                where('id', '!=', $product->id)->
                where('category_id', $product->category_id)->
                inRandomOrder()->
                limit(12)->
                get();

            return response()->json([
                "message"=>"Product retrieved successfully.",
                "data"=>new ProductResource($product),
                "dataRelated"=>ProductResource::collection($relatedProducts),
            ],200);
        }catch(\Exception $err) {
            return response()->json(["message"=>$err->getMessage()], 500);
        }
    }
    public function get_by_filter(Request $request)
    {
        try {
            $color = $request->input('color');
            $size = $request->input('size');
            $gender = $request->input('gender');
            $category = $request->input('category'); 
    
            $productsQuery = Product::
                with([
                    'galeries',
                    'variants'=>function($query){
                        $query->where('status',1);
                    }
                ])->
                where("status",1);
    
            if ($color) {
                $productsQuery->whereHas('variants.attributeValues', function ($query) use ($color) {
                    $query->whereHas('attribute', function ($q) {
                        $q->where('slug', 'color');
                    })
                    ->where('slug', $color);
                });
            }

            if ($size) {
                $productsQuery->whereHas('variants.attributeValues', function ($query) use ($size) {
                    $query->whereHas('attribute', function ($q) {
                        $q->where('slug', 'size');
                    })
                    ->where('slug', $size);
                });
            }

            if ($gender) {
                $productsQuery->where('gender', $gender);
            }

            if ($category) {
                $productsQuery->whereHas('category', function ($query) use ($category) {
                    $query->where('slug', $category);
                });
            }
    
            $products=$productsQuery->latest()->paginate(6);

            return response()->json([
                "message" => "Products retrieved successfully.",
                "data" => ProductResource::collection($products),
                "meta" => [
                    "current_page" => $products->currentPage(),
                    "last_page" => $products->lastPage(),
                    "per_page" => $products->perPage(),
                    "total" => $products->total(),
                ]
            ], 200);
    
        } catch (\Exception $err) {
            return response()->json(["message" => $err->getMessage()], 500);
        }
    }
}

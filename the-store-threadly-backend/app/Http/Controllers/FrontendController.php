<?php

namespace App\Http\Controllers;

use App\Http\Resources\AttributeValueResource;
use App\Http\Resources\BlogResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Attribute;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function product_get_all () 
    {
        try{
            $products=Product::
                with('galeries','variants')->
                where('status',1)->
                inRandomOrder()->
                get();

            $colorAttribute = Attribute::where('slug', 'color')->first();
            $usedColorAttributes = [];
            if ($colorAttribute)
                $usedColorAttributes=$colorAttribute->attributeValues()
                    ->whereHas('variants')
                    ->get()
                    ->unique('id');

            $sizeAttribute = Attribute::where('slug', 'size')->first();
            $usedSizeAttributes = [];
            if ($sizeAttribute)
                $usedSizeAttributes=$sizeAttribute->attributeValues()
                    ->whereHas('variants')
                    ->get()
                    ->unique('id');

            $usedCategories = Category::whereHas('products')
                ->with('parent')
                ->get();
            
            return response()->json([
                "message"=>"Products retrieved successfully.",
                "data"=>ProductResource::collection($products),
                "categories" => CategoryResource::collection($usedCategories),
                "colors"=>AttributeValueResource::collection($usedColorAttributes),
                "sizes"=>AttributeValueResource::collection($usedSizeAttributes),
            ],200);
        }catch(\Exception $err) {
            return response()->json(["message"=>$err->getMessage()], 500);
        }
    }

    public function product_get_all_by_new () 
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

    public function product_get_all_by_featured () 
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

    public function product_get_one_by_slug ($slug) 
    {
        try{
            $product= Product::
                with('galeries','variants')->
                where('slug', $slug)->
                firstOrFail();

            return response()->json([
                "message"=>"Product retrieved successfully.",
                "data"=>new ProductResource($product),
            ],200);
        }catch(\Exception $err) {
            return response()->json(["message"=>$err->getMessage()], 500);
        }
    }

    public function product_filter(Request $request)
    {
        try {
            $color = $request->input('color');
            $size = $request->input('size');
            $gender = $request->input('gender');
            $category = $request->input('category'); 
    
            $productsQuery = Product::
                with('galeries','variants');
    
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
    
            $products=$productsQuery->latest()->get();

            return response()->json([
                "message" => "Products retrieved successfully.",
                "data" => ProductResource::collection($products),
            ], 200);
    
        } catch (\Exception $err) {
            return response()->json(["message" => $err->getMessage()], 500);
        }
    }

    public function blog_get_all () 
    {
        try{
            $blogs=Blog::
                where('status',1)->
                inRandomOrder()->
                get();
            
            return response()->json([
                "message"=>"Blogs retrieved successfully.",
                "data"=>BlogResource::collection($blogs),
            ],200);
        }catch(\Exception $err) {
            return response()->json(["message"=>$err->getMessage()], 500);
        }
    }
}

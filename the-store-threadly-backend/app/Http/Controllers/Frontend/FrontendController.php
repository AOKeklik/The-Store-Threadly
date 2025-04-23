<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttributeResource;
use App\Http\Resources\CategoryResource;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Slider;
use App\Models\SliderBrand;

class FrontendController extends Controller
{
    public function setting_get () 
    {
        try{
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

            $usedProductCategories = Category::whereHas('products')
                ->with('parent')
                ->get();

            $usedBlogCategories = Category::whereHas('blogs')
                ->with('parent')
                ->get();

            return response()->json([
                "message"=>"Setting items retrieved successfully.",
                "data"=>settings(),
                "product_categories" => CategoryResource::collection($usedProductCategories),
                "blog_categories" => CategoryResource::collection($usedBlogCategories),
                "colors"=>AttributeResource::collection($usedColorAttributes),
                "sizes"=>AttributeResource::collection($usedSizeAttributes),
            ],200);
        }catch(\Exception $err) {
            return response()->json(["message"=>$err->getMessage()], 500);
        }
    }


    /* ///////////// SLIDER  ///////////// */
    public function slider_hero_get_all () 
    {
        try{
            $sliders = Slider::where('status', 1)
                ->latest()
                ->get()
                ->map(function ($slider) {
                    return [
                        'id' => $slider->id,
                        'title' => $slider->title,
                        'desc' => $slider->desc,
                        'image' => $slider->getImage(),
                        'url' => $slider->url,
                    ];
                });
            
            return response()->json([
                "message"=>"Sliders retrieved successfully.",
                "data"=>$sliders,
            ],200);
        }catch(\Exception $err) {
            return response()->json(["message"=>$err->getMessage()], 500);
        }
    }
    public function slider_brand_get_all () 
    {
        try{
            $sliders = SliderBrand::where('status', 1)
                ->latest()
                ->get()
                ->map(function ($slider) {
                    return [
                        'id' => $slider->id,
                        'image' => $slider->getImage(),
                        'url' => $slider->url,
                    ];
                });
            
            return response()->json([
                "message"=>"Sliders retrieved successfully.",
                "data"=>$sliders,
            ],200);
        }catch(\Exception $err) {
            return response()->json(["message"=>$err->getMessage()], 500);
        }
    }    
}

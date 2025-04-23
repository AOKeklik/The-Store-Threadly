<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SliderBrand;
use App\Services\ImageService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminSliderBrandController extends Controller
{
    public function index() :View
    {
        $sliders=SliderBrand::orderBy("id","desc")->get();
        return view("admin.slider-brand.index",compact("sliders"));
    }
    public function section_table_view() :View
    {
        $sliders=SliderBrand::orderBy("id","desc")->get();
        return view("admin.slider-brand.table",compact("sliders"));
    }
    public function add_view() :View
    {
        return view("admin.slider-brand.add");
    }
    public function edit_view($slider_id)
    {
        $slider=SliderBrand::find($slider_id);

        if(!$slider)
            return redirect()->route("admin.slider.view")->with("error","The slider not found.");

        return view("admin.slider-brand.edit",compact("slider"));
    }


    public function store(Request $request,ImageService $imageService) 
    {
        try{
            $validator = \Validator::make($request->all(),[
                "image"=>"required|file|mimes:jpg,jpeg,png|max:1048576",
                "url"=>"nullable|url",
            ]);

            if(!$validator->passes())
                return response()->json(["message"=>$validator->errors()->toArray()],422);
    
            $slider=new SliderBrand();
            $image = $imageService->uploadPhoto($request,null,"slider-brand");
    
            $slider->image=$image;
            $slider->url=$request->url;
    
            if(!$slider->save())
                throw new \Exception("Failed to save slide."); 
    
            return response()->json(["message"=>"Slider added successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function update(Request $request,ImageService $imageService) 
    {
        try{
            $validator = \Validator::make($request->all(),[
                "image"=>"nullable|file|mimes:jpg,jpeg,png|max:1048576",
                "url"=>"nullable|url",
            ]);

            if(!$validator->passes())
                return response()->json(["message"=>$validator->errors()->toArray()],422);
    
            $slider=SliderBrand::find($request->id);

            if(!$slider)
                throw new \Exception("Slider not found."); 

            $image = $imageService->uploadPhoto($request,$slider,"slider-brand");
    
            $slider->image=$image;
            $slider->url=$request->url;
    
            if(!$slider->save())
                throw new \Exception("Failed to update slide."); 
    
            return response()->json(["message"=>"Slider updated successfully.","redirect"=>route("admin.slider.brand.view")],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function status_update(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(),[
                'status' => 'required|numeric',
            ]);
    
            if(!$validator->passes())
                return response()->json(["message" => $validator->errors()->first()],422);
    
            $slider=SliderBrand::find($request->id);
    
            if(!$slider)
                throw new \Exception("Slider not found.");
    
            $slider->status=$request->status;
    
            if(!$slider->save()) 
                throw new \Exception("Failed to update slider status.");
    
            return response()->json(["message"=>"Slider status updated successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function delete(Request $request)
    {
        try{    
            $slider=SliderBrand::find($request->id);
    
            if(!$slider)
                throw new \Exception("Slider not found.");
    
            $image=public_path("uploads/slider-brand/").$slider->image;
            if(is_file($image))
                unlink($image);
    
            if(!$slider->delete())
                throw new \Exception("Failed to delete the slide.");
    
            return response()->json(["message"=>"The slider deleted successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
}

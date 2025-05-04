<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\ImageService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    function index(): View
    {
        return view('admin.setting.index');
    }

    function setting_general_update(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(), [
                'site_name' => "required|string|max:255",
                'site_email' => "required|email|max:255",
                'site_phone' => "required|string|max:255",
                'site_address' => "required|string|max:255",
                'site_copy' => "required|string|max:255",
                'site_map' => "required|string",
            ]);

            if($validator->fails())
                return response()->json(["message" => $validator->errors()->toArray()],422);
    
            foreach ($validator->validated() as $key => $value) {
                Setting::setValue($key,$value);
            }

            Setting::clearCache();
                
            return response()->json(["message"=>"Setting general updated successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    
    function setting_ecommerce_update(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(), [
                'site_delivery_free_threshold'=> "required|numeric",
                'site_currency_icon'=> "required|string|max:255",
                'site_currency_icon_position' => "required|string|max:255",
            ]);

            if($validator->fails())
                return response()->json(["message" => $validator->errors()->toArray()],422);
    
            foreach ($validator->validated() as $key => $value) {
                Setting::setValue($key,$value);
            }

            Setting::clearCache();
                
            return response()->json(["message"=>"Setting ecommerce updated successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }

    function setting_email_update(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(), [
                'mail_driver' => "required|string|max:255",
                'mail_host' => "required|string|max:255",
                'mail_port' => "required|numeric|max:5000",
                'mail_username' => "required|string|max:255",
                'mail_password' => "required|string|max:255",
                'mail_encryption' => "required|string|max:10",
                'mail_from_address' => "required|email|max:255",
                'mail_receive_address' => "required|email|max:255",
            ]);

            if($validator->fails())
                return response()->json(["message" => $validator->errors()->toArray()],422);
    
            foreach ($validator->validated() as $key => $value) {
                Setting::setValue($key,$value);
            }

            Setting::clearCache();
                
            return response()->json(["message"=>"Setting email updated successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }

    function setting_image_update(Request $request,ImageService $imageService)
    {
        try{
            $validator = \Validator::make($request->all(), [
                'site_favicon' => "nullable|file|mimes:png|max:1000",
                'site_logo' => "nullable|file|mimes:png,jpg,jpeg|max:1000",
            ]);

            if($validator->fails())
                return response()->json(["message" => $validator->errors()->toArray()],422);
    
            foreach ($validator->validated() as $key => $file) {
                $image = $imageService->uploadSettingPhoto($request,$key,"setting");
                Setting::setValue($key,$image);
            }

            Setting::clearCache();
                
            return response()->json(["message"=>"Setting image updated successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }

    function setting_link_update(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(), [
                'link_facebook' => "required|url|max:255",
                'link_linkedin' => "required|url|max:255",
                'link_twitter' => "required|url|max:255",
                'link_instagram' => "required|url|max:255",
                'link_youtube' => "required|url|max:255",
            ]);

            if($validator->fails())
                return response()->json(["message" => $validator->errors()->toArray()],422);
    
            foreach ($validator->validated() as $key => $value) {
                Setting::setValue($key,$value);
            }

            Setting::clearCache();
                
            return response()->json(["message"=>"Setting link updated successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
}

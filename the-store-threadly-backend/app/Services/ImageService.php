<?php

namespace App\Services;

use App\Models\Setting;

class ImageService
{
    public function uploadPhoto($request,$model=null,$path)
    {
        try{
            $image = $model?->image ?? null;
            
            if($request->hasFile("image")){
                $uploadPath = public_path("uploads/".$path."/");
                $file = $request->file("image");

                if (!file_exists($uploadPath))
                    mkdir($uploadPath, 0755, true);

                if($image && file_exists($uploadPath.$image))
                    unlink($uploadPath.$image);

                $image=uniqid().".".$file->getClientOriginalExtension();
                $file->move($uploadPath,$image);
            }

            return $image;
        }catch(\Exception $err){
            throw $err;
        }
    }
    public function uploadCover($request,$model=null,$path)
    {
        try{
            $cover = $model?->cover ?? null;
            
            if($request->hasFile("cover")){
                $uploadPath = public_path("uploads/".$path."/");
                $file = $request->file("cover");

                if (!file_exists($uploadPath))
                    mkdir($uploadPath, 0755, true);

                if($cover && file_exists($uploadPath.$cover))
                    unlink($uploadPath.$cover);

                $cover=uniqid().".".$file->getClientOriginalExtension();
                $file->move($uploadPath,$cover);
            }

            return $cover;
        }catch(\Exception $err){
            throw $err;
        }
    }
    public function uploadSettingPhoto($request,$key,$path)
    {
        try{
            $table = Setting::where("key", $key)->first();
            $image = $table?->value ?? null;
            $uploadPath = "uploads/".$path."/";

            if($request->hasFile($key)){
                $file = $request->file($key);
                
                if($image && is_file(public_path($uploadPath.$image)))
                unlink(public_path($uploadPath.$image));
            
                $image=uniqid().".".$file->getClientOriginalExtension();
                $file->move(public_path($uploadPath),$image);
            }

            return $image;
        }catch(\Exception $err){
            throw $err;
        }
    }
}
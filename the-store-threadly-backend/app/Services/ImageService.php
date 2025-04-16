<?php

namespace App\Services;


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
}
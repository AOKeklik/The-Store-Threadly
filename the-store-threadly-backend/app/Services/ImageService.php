<?php

namespace App\Services;


class ImageService
{
    public function uploadPhoto($request,$model=null,$path)
    {
        try{
            $image = $model?->image ?? null;
            $uploadPath = public_path("uploads/".$path."/");

            if($request->hasFile("image")){
                $file = $request->file("image");

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
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminProfileController extends Controller
{
    public function index():View
    {
        return view("admin.profile.index");
    }

    public function profile_update(Request $request, ImageService $imageService)
    {
        try{
            $validator = \Validator::make($request->all(),[
                "name"=>"required|string",
                "email"=>[
                    "required",
                    "email",
                    Rule::unique("users","email")->ignore(auth()->user()->id)
                ],
                "image"=>"nullable|file|mimes:jpg,jpeg,png|max:1048576",
            ]);

            if(!$validator->passes())
                return response()->json(["message"=>$validator->errors()->toArray()],422);

            $user=User::find(auth()->user()->id);

            if(!$user)
                throw new \Exception("User not found.");

            $image = $imageService->uploadPhoto($request,$user,"user");

            $user->name=$request->name;
            $user->email=$request->email;
            $user->image=$image;

            if($request->filled("password")) {
                $validator = \Validator::make($request->all(),[
                    "password"=>"required|string|min:8|max:13",
                    "confirm-password"=>"required|string|min:8|same:password",
                ]);
    
                if(!$validator->passes())
                    return response()->json(["message"=>$validator->errors()->toArray()],422);

                
                $user->password=Hash::make($request->password);
            }

            if(!$user->save())
                throw new \Exception("Failed to update profile.");
            
            return response()->json(["message"=>"Profile updated successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function profile_password_update(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(),[
                "old_password"=>"required|string|min:7|max:13",
                "password"=>"required|string|min:7|max:13",
                "confirm_password"=>"required|string|same:password"
            ]);

            if(!$validator->passes())
                return response()->json(["form_error"=>["message"=>$validator->errors()->toArray()]]);

            $user=User::find(auth()->user()->id);

            if(!$user)
                throw new \Exception("User not found.");

            if(!password_verify($request->old_password,$user->password))
                throw new \Exception("Current password is incorrect.");

            $user->password=password_hash($request->password,PASSWORD_DEFAULT);

            if(!$user->update())
                throw new \Exception("Failed to update the password.");

            return response()->json(["success"=>["message"=>"Password updated successfully."]]);
        }catch(\Exception $err){
            return response()->json(["error"=>["message"=>$err->getMessage()]]);
        }
    }
}

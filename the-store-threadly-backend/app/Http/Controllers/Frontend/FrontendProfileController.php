<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\CustomerData;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\Request;

class FrontendProfileController extends Controller
{
    public function index(Request $request)
    {
        $customer = CustomerData::
            where('user_id', $request->user()->id)
            ->first();

        return response()->json([
            "success" => true,
            "message"=>"Customer profile retrieved successfully.",
            "data"=> new CustomerResource($customer)
        ],200);
    }

    public function profile_update(Request $request, ImageService $imageService)
    {
        $request->validate([
            "name" => "required|string",
            "email" => [
                "required",
                "email",
                \Illuminate\Validation\Rule::unique("users", "email")->ignore($request->user()->id)
            ],
            "image" => "nullable|file|mimes:jpg,jpeg,png|max:1048576",
        ]);

        $user = $request->user();

        $image = $imageService->uploadPhoto($request,$user,"customer");

        $user->update([
            "name"=>$request->name,
            "email"=>$request->email,
            "image"=>$image,
        ]);
        
        return response()->json(["message"=>"Profile updated successfully."],200);
    }
    public function password_update(Request $request)
    {
        $user= $request->user();

        if(!\Hash::check($request->password_existing, $user->password))
            return response()->json([
                'success' => false,
                'error_type' => 'validation',
                'message' => 'Validation failed',
                'errors' =>  [
                    "password_existing" => ["The current password is incorrect."]
                ],
                "type" => "validation",
            ], 422);

        $request->validate([
            "password_existing"=>"required|string|min:7|max:13",
	        "password"=>[
                "required",
                "string",
                "min:8",
                "max:32",
                \Illuminate\Validation\Rules\Password::min(8)
                    // ->mixedCase()
                    // ->numbers()
                    // ->symbols()
                    // ->uncompromised(),
            ],
	        "password_confirmation"=>"required|string|same:password"
        ]);

        $user->update([
            "password" => \Hash::make($request->password)
        ]);
        
        return response()->json(["message"=>"Password updated successfully."],200);
    }
    public function address_update(Request $request)
    {
        $user= $request->user();

        $request->validate([
            "phone"=>"nullable|string|max:255",
            "country"=>"nullable|string|",
            "state"=>"nullable|string|max:255",
            "city"=>"nullable|string|max:255",
            "zip"=>"nullable|string|max:255",
            "address"=>"nullable|string|max:500",
        ]);

        $user->detail->update([
            "phone" => $request->phone,
            "country" => $request->country,
            "state" => $request->state,
            "city" => $request->city,
            "zip" => $request->zip,
            "address" => $request->address,
        ]);
        
        return response()->json(["message"=>"Address updated successfully."],200);
    }
}

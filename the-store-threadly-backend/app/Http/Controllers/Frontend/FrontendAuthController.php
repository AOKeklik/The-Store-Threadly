<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\CustomerSignupMail;
use App\Models\User;
use Illuminate\Http\Request;

class FrontendAuthController extends Controller
{
    public function signin(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                "name"=>"required|string|max:255",
                "email"=>"required|email|unique:users,email",
                "password" => [
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
                "password_confirmation" => "required|string|same:password"
            ]);

            if($validator->fails())
                return response()->json(["message" => $validator->errors()->toArray()],422);
    
            $token = \Illuminate\Support\Str::random(64);
	        $hashed_token = hash('sha256', $token);

            User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => \Hash::make($request->password),
                "email_verification_token" => $token,
                "email_verified_at" => null,
            ]);

            \Mail::to($request->email)->send(new CustomerSignupMail($request->email,$hashed_token));
            
            return response()->json(["message"=>"User registered successfully. Please check your email for verification."],200);
        }catch(\Exception $err){
            return response()->json(["message" =>$err->getMessage()],500);
        }
    }
    public function signup(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                "name"=>"required|string|max:255",
                "email"=>"required|email|unique:users,email",
                "password" => [
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
                "password_confirmation" => "required|string|same:password"
            ]);

            if($validator->fails())
                return response()->json(["message" => $validator->errors()->toArray()],422);
    
            $token = \Illuminate\Support\Str::random(64);
	        $hashed_token = hash('sha256', $token);

            User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => \Hash::make($request->password),
                "email_verification_token" => $token,
                "email_verified_at" => null,
            ]);

            \Mail::to($request->email)->send(new CustomerSignupMail($request->email,$hashed_token));
            
            return response()->json(["message"=>"User registered successfully. Please check your email for verification."],200);
        }catch(\Exception $err){
            return response()->json(["message" =>$err->getMessage()],500);
        }
    }
    public function signup_verify(Request $request)
    {
        try {
            $customer = User::where("email", $request->email)->first();

            if(!$customer)
                throw new \Exception("Invalid or expired reset token.");


            if(!hash_equals(hash('sha256', $customer->email_verification_token),$request->token))
                throw new \Exception("Invalid or expired reset token.");

            $customer->update([
                "email_verification_token" => null,
                "email_verified_at" => now(),
                "status" => 1
            ]);
            
            return redirect()->away(env('FRONTEND_URL').'/signin')->with('verified', true);
        }catch(\Exception $err){
            return response()->json(["message" =>$err->getMessage()],500);
        }
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\CustomerResetMail;
use App\Mail\CustomerSignupMail;
use App\Models\User;
use Illuminate\Http\Request;

class FrontendAuthController extends Controller
{
    public function signin(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                "email"=>"required|email|exists:users,email",
                "password" => "required"
            ]);

            if($validator->fails())
                return response()->json(["message" => $validator->errors()->toArray()],422);
    
            $credential=[
                "email"=>$request->email,
                "password"=>$request->password,
                "status"=>1,
            ];

            if(!auth()->attempt($credential))
                return response()->json(['message' => 'Invalid credentials or inactive account.'], 401);
            
            return response()->json(["message"=>"Login successful! Welcome back."],200);
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
            
            return redirect()->away(env("app_frontend_url").'/signin')->with('verified', true);
        }catch(\Exception $err){
            return response()->json(["message" =>$err->getMessage()],500);
        }
    }

    public function reset(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                "email"=>"required|email|exists:users,email",
            ]);

            if($validator->fails())
                return response()->json(["message" => $validator->errors()->toArray()],422);
    
            $customer = User::where("email",$request->email)->firstOrFail();

            $token = \Illuminate\Support\Str::random(64);
	        $hashed_token = hash('sha256', $token);

            $customer->update([
                "email_verification_token" => $token,
                "email_verified_at" => now(),
                "status" => 0
            ]);

            \Mail::to($request->email)->send(new CustomerResetMail($request->email,$hashed_token));
            
            return response()->json(["message"=>"Please check your email and follow the reset instructions."],200);
        }catch(\Exception $err){
            return response()->json(["message" =>$err->getMessage()],500);
        }
    }
    public function reset_verify(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                "password"=> [
                    "required",
                    "string",
                    "min:8",
                    "max:32",
                    \Illuminate\Validation\Rules\Password::min(8)
                        // ->mixedCase()
                        // ->numbers()
                        // ->symbols()
                        // ->uncompromised()
                ],
                "password_confirmation"=>"required|string|same:password"
            ]);

            if($validator->fails())
                return response()->json(["message" => $validator->errors()->toArray()],422);
    
            $customer = User::where("email",$request->email)->firstOrFail();

            if(!hash_equals(hash("sha256",$customer->email_verification_token), $request->token))
                throw new \Exception("Invalid email address or token!");

            $tokenExpired = now()->diffInMinutes($customer->email_verified_at) > config('auth.passwords.users.expire');
	        
            if ($tokenExpired)
                throw new \Exception("Reset token has expired. Please request a new one.");

            $customer->update([
                "password" => \Hash::make($request->password),
                "email_verification_token" => null,
                "email_verified_at" => null,
                "status" => 1
            ]);
            
            return response()->json(["message"=>"Password has been successfully reset."],200);
        }catch(\Exception $err){
            return response()->json(["message" =>$err->getMessage()],500);
        }
    }
}

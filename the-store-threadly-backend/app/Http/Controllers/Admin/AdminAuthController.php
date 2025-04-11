<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminAuthenticateMail;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{
    public function index():View
    {
        $todayOrderes=Order::whereDay("created_at",Carbon::today())->get();
        $yesterdayOrderes=Order::whereDay("created_at",Carbon::yesterday())->get();
        $monthOrderes=Order::whereMonth("created_at",Carbon::now()->month)->get();
        $yearOrderes=Order::whereYear("created_at",Carbon::today()->year)->get();

        $activeCustomers=User::
            where("status",1)->
            where("role","customer")->
            get();

        return view("admin.index",compact(
            "todayOrderes","yesterdayOrderes","monthOrderes","yearOrderes","activeCustomers"
        ));
    }
    public function signin_view():View
    {
        return view("admin.auth.signin");
    }
    public function forget_view():View
    {
        return view("admin.auth.forget");
    }
    public function reset_view(Request $request)
    {
        try{
            $admin = User::where("email", $request->email)->first();

            if(!$admin)
                throw new \Exception("Invalid or expired reset token.");

            $tokenExpired = now()->diffInMinutes($admin->password_requested_at) > config('auth.passwords.users.expire');
        
            if ($tokenExpired)
                throw new \Exception("Reset token has expired. Please request a new one.");

            if(!hash_equals(hash('sha256', $admin->remember_token),$request->token))
                throw new \Exception("Invalid or expired reset token.");

            return view("admin.auth.reset",["token"=>$request->token,"email"=>$request->email]);
        }catch(\Exception $err){
            return redirect()->route("admin.signin.view")->with("error",$err->getMessage());
        }
    }

    public function signin_submit(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                "email"=>"required|email|exists:users,email",
                "password"=>"required|string|min:8|max:13",
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
            
            return response()->json(["message"=>"Login successful! Welcome back.","redirect"=>route("admin.view")],200);
        }catch(\Exception $err){
            return response()->json(["message" =>$err->getMessage()],500);
        }
    }
    public function forget_submit(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                "email"=>"required|email|exists:users,email",
            ]);

            if($validator->fails())
                return response()->json(["message" => $validator->errors()->toArray()],422);
    
            $admin = User::where("email",$request->email)->first();

            if(!$admin)
                throw new \Exception("User not found.");
            
            $token = Str::random(64);
            $hashed_token = hash('sha256', $token);

            $admin->status=0;
            $admin->remember_token=$token;
            $admin->password_requested_at = now();
            
            if(!$admin->save())
                throw new \Exception("Failed to update user status. Please try again.");
    
            \Mail::to($request->email)->send(new AdminAuthenticateMail($admin->email, $hashed_token));
            
            return response()->json(["message"=>"Please check your email and follow the reset instructions.","redirect"=>route("admin.signin.view"),200]);
        }catch(\Exception $err){
            return response()->json(["message" =>$err->getMessage()],500);
        }
    }
    public function reset_submit(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(), [
                "password"=>"required|string|min:8|max:13",
                "confirm-password"=>"required|string|min:8|same:password",
            ]);

            if($validator->fails())
                return response()->json(["message" => $validator->errors()->toArray()],422);
    
            $admin=User::where("email", $request->email)->first();
    
            if(!$admin)
                throw new \Exception("Invalid email address or token!");
    
            if(!hash_equals(hash("sha256",$admin->remember_token), $request->token))
                throw new \Exception("Invalid email address or token!");
    
            $admin->password=Hash::make($request->password);
            $admin->remember_token=null;
            $admin->password_requested_at=null;
            $admin->status=1;
            
            if(!$admin->update())
                throw new \Exception("Failed to update user details. Please try again.");
    
            return response()->json(["message"=>"Password has been updated usccessfully!","redirect"=>route("admin.signin.view")],200);
        }catch(\Exception $err){
            return response()->json(["message" =>$err->getMessage()],500);
        }
    }
    public function signout_submit()
    {
        try{
            auth()->logout();
            session()->invalidate();
            session()->regenerateToken();

            return response()->json(["message"=>"Successfully logged out.","redirect"=>route("admin.signin.view")],200);
        }catch(\Exception $err){
            return response()->json(["message" =>$err->getMessage()],500);
        }
    }
}

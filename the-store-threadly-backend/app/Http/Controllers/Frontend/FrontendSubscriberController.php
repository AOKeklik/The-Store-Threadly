<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\SubscriberFormSubmitted;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class FrontendSubscriberController extends Controller
{
    public function store(Request $request)
    {
        try{
            $validated = \Validator::make($request->all(), [
                'email' => 'required|email|unique:subscribers,email'
            ]);

            if ($validated->fails())
                return response()->json(["message"=>$validated->errors()->toArray()], 422);

            $formData = $validated->validated();
            $formData['ip'] = $request->ip();

            $subscriber = Subscriber::create($formData);

            \Mail::send(new SubscriberFormSubmitted([
                'email' => $subscriber->email,
                'ip' => $subscriber->ip,
                'status' => $subscriber->status,
            ]));

            return response()->json([
                "message"=>"Subscriber added successfully.",
                "data"=>null
            ],200);
        }catch(\Exception $err) {
            return response()->json(["message"=>$err->getMessage()], 500);
        }
    }
}

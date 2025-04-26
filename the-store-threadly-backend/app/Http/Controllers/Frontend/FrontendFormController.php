<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormSubmitted;
use App\Mail\SubscriberFormSubmitted;
use App\Models\Contact;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class FrontendFormController extends Controller
{
    public function subscriber_store(Request $request)
    {
        try{
            $validated = \Validator::make($request->all(), [
                'email' => 'required|email|unique:subscribers,email'
            ]);

            $ip = $request->ip();

            $validated->after(function ($validator) use ($ip) {
                if (\App\Models\Subscriber::where('ip', $ip)->exists()) {
                    $validator->errors()->add('email', 'This IP address is already subscribed.');
                }
            });

            if ($validated->fails())
                return response()->json(["message"=>$validated->errors()->toArray()], 422);

            $formData = $validated->validated();
            $formData['ip'] = $ip;

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

    public function contact_store(Request $request)
    {
        try{
            $validated = \Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'subject' => 'required|string|max:255',
                'message' => 'required|string|max:1000',
            ]);

            if ($validated->fails())
                return response()->json(["message"=>$validated->errors()->toArray()], 422);

            Contact::create($validated->validated());
            \Mail::send(new ContactFormSubmitted($validated->validated()));

            return response()->json([
                "message"=>"Your message has been sent successfully",
                "data"=>null
            ],200);
        }catch(\Exception $err) {
            return response()->json(["message"=>$err->getMessage()], 500);
        }
    }
}

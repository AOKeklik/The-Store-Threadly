<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminSubscriberController extends Controller
{
    public function index() :View
    {
        $subscribers=Subscriber::orderBy("id","desc")->get();            
        return view("admin.subscriber.index",compact("subscribers"));
    }
    public function section_table_view() :View
    {
        $subscribers=Subscriber::orderBy("id","desc")->get();
        return view("admin.subscriber.table",compact("subscribers"));
    }
    public function edit_view($id)
    {
        $subscriber=Subscriber::find($id);

        if(!$subscriber)
            return redirect()->route("admin.subscriber.view")->with("error","The subscriber not found.");

        return view("admin.subscriber.edit",compact("subscriber"));
    }


    public function update(Request $request) 
    {
        try{
            $validator = \Validator::make($request->all(),[
                "ip"=>"required|string|max:255",
                "email"=>"required|email|max:255",
            ]);

            if(!$validator->passes())
                return response()->json(["message"=>$validator->errors()->toArray()],422);

            $subscriber=Subscriber::find($request->id);

            if(!$subscriber)
                throw new \Exception("Subscriber not found."); 
    
            $subscriber->ip=$request->ip;
            $subscriber->email=$request->email;
    
            if(!$subscriber->save())
                throw new \Exception("Failed to save subscriber."); 
    
            return response()->json(["message"=>"Subscriber updated successfully.","redirect"=>route("admin.subscriber.view")],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function status_update(Request $request)
    {
        try{
            $validated = \Validator::make($request->all(),[
                'status_type' => 'required|string|in:status',
                'status_value' => 'required|boolean'
            ]);

            if($validated->fails())
                throw new \Exception($validated->errors()->first());
    
            $blog=Subscriber::find($request->id);
    
            if(!$blog)
                throw new \Exception("Subscriber not found.");
        
            if(!$blog->update([
                $request->status_type => $request->status_value
            ]))
                throw new \Exception("Failed to save status."); 
    
            return response()->json(["message"=>"Status updated successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function delete(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(), [
                "id" => "required|numeric|exists:subscribers,id"
            ]);
    
            if($validator->fails())
	            throw new \Exception($validator->errors()->first());
    
            $subscriber=Subscriber::find($request->id);
    
            if(!$subscriber)
                throw new \Exception("Subscriber not found.");
    
            if(!$subscriber->delete())
                throw new \Exception("Failed to delete the subscriber.");
    
            return response()->json(["message"=>"Subscriber deleted successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
}

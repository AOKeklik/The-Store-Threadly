<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminContactController extends Controller
{
    public function index() :View
    {
        $contacts=Contact::orderBy("id","desc")->get();            
        return view("admin.contact.index",compact("contacts"));
    }
    public function section_table_view() :View
    {
        $contacts=Contact::orderBy("id","desc")->get();
        return view("admin.contact.table",compact("contacts"));
    }
    public function section_unread_view() :View
    {
        return view("admin.contact.unread");
    }
    public function detail_view($id)
    {
        try{    
            $contact=Contact::find($id);
            $contact->update(['is_viewed' => 1]);

            if(!$contact)
                throw new \Exception("Contact not found.");
    
            return view("admin.contact.detail",compact("contact"));
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }

    public function delete(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(), [
                "id" => "required|numeric|exists:contacts,id"
            ]);
    
            if($validator->fails())
                throw new \Exception($validator->errors()->first());
    
            $contact=Contact::find($request->id);
    
            if(!$contact)
                throw new \Exception("Contact not found.");
    
            if(!$contact->delete())
                throw new \Exception("Failed to delete the contact.");
    
            return response()->json(["message"=>"Contact deleted successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
}

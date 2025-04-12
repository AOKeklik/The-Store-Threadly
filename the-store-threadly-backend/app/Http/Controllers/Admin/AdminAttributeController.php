<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminAttributeController extends Controller
{
    public function index() :View
    {
        $attributes=Attribute::orderBy("id","desc")->get();
        return view("admin.attribute.index",compact("attributes"));
    }
    public function attribute_section_table_view() :View
    {
        $attributes=Attribute::orderBy("id","desc")->get();
        return view("admin.attribute.table",compact("attributes"));
    }
    public function attribute_section_select_view() :View
    {
        $attributes=Attribute::orderBy("id","desc")->get();
        return view("admin.attribute.select",compact("attributes"));
    }
    public function attribute_edit_view($id)
    {
        $attribute=Attribute::find($id);

        if(!$attribute)
            return redirect()->route("admin.attribute.view")->with("error","The attribute not found.");

        return view("admin.attribute.edit",compact("attribute"));
    }
    public function attribute_value_edit_view($id)
    {
        $attributeValue=AttributeValue::find($id);
        $attributes=Attribute::orderBy("id","desc")->get();

        if(!$attributeValue)
            return redirect()->route("admin.attribute.view")->with("error","The attribute value not found.");

        return view("admin.attribute.edit-value",compact("attributes","attributeValue"));
    }

    public function attribute_store(Request $request) 
    {
        try{
            $validator = \Validator::make($request->all(), [
                "name" => "required|string|unique:attributes,name",
            ]);

            if(!$validator->passes())
                return response()->json(["message"=>$validator->errors()->toArray()],422);
    
            $attribute=new Attribute();
            $attribute->name=$request->name;
    
            if(!$attribute->save())
                throw new \Exception("Failed to save attribute."); 
    
            return response()->json(["message"=>"Attribute added successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function attribute_update(Request $request) 
    {
        try{
            $validator = \Validator::make($request->all(),[
                "name"=>[
                    "required",
                    "string",
                    Rule::unique("attributes","name")->ignore($request->id)
                ]
            ]);

            if(!$validator->passes())
                return response()->json(["message"=>$validator->errors()->toArray()],422);
    
            $attribute=Attribute::find($request->id);

            if(!$attribute)
                throw new \Exception("Attribute not found.");

            $attribute->name=$request->name;
    
            if(!$attribute->save())
                throw new \Exception("Failed to update attribute."); 
    
            return response()->json(["message"=>"Attribute updated successfully.","redirect"=>route("admin.attribute.view")],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function attribute_value_store(Request $request) 
    {
        try{
            $validator = \Validator::make($request->all(),[
                "attribute_id"=>"required|numeric|exists:attributes,id",
                "value"=>"required|string|unique:attribute_values,value",
                "icon"=>"nullable|string",
            ]);

            if(!$validator->passes())
                return response()->json(["message"=>$validator->errors()->toArray()],422);
    
            $attribute=new AttributeValue();
            $attribute->attribute_id=$request->attribute_id;
            $attribute->value=$request->value;
            $attribute->icon=$request->icon;
    
            if(!$attribute->save())
                throw new \Exception("Failed to save clhild attribute."); 
    
            return response()->json(["message"=>"Child Attribute added successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function attribute_value_update(Request $request) 
    {
        try{
            $validator = \Validator::make($request->all(),[
                "attribute_id" => "required|numeric|exists:attributes,id",
                "value"=>[
                    "required",
                    "string",
                    Rule::unique("attribute_values","value")->ignore($request->id)
                ],
                "icon"=>"nullable|string",
            ]);

            if(!$validator->passes())
                return response()->json(["message"=>$validator->errors()->toArray()],422);
    
            $attributeValues=AttributeValue::
                where("id",$request->id)->
                where("attribute_id",$request->attribute_id)->
                first();

            if(!$attributeValues)
                throw new \Exception("Attribute not found.");

            $attributeValues->attribute_id=$request->attribute_id;
            $attributeValues->value=$request->value;
            $attributeValues->icon=$request->icon;
    
            if(!$attributeValues->save())
                throw new \Exception("Failed to update attribute value."); 
    
            return response()->json(["message"=>"Attribute value updated successfully.","redirect"=>route("admin.attribute.view")],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function attribute_delete(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(), [
                "attribute_id" => "required|numeric|exists:attributes,id"
            ]);
    
            if($validator->fails())
                throw new \Exception($validator->errors()->first());
    
            $attribute=Attribute::find($request->attribute_id);
    
            if(!$attribute)
                throw new \Exception("Attribute not found.");

            $attributeValues=AttributeValue::where("attribute_id",$request->attribute_id)->get();

            foreach ($attributeValues as $value)
                if(!$value->delete())
                    throw new \Exception("Failed to delete the attribute.");

            if(!$attribute->delete())
                throw new \Exception("Failed to delete the attribute.");
    
            return response()->json(["message"=>"The attribute deleted successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function attribute_value_delete(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(), [
                "id" => "required|numeric|exists:attribute_values,id",
                "attribute_id" => "required|numeric|exists:attributes,id",
            ]);
    
            if($validator->fails())
                throw new \Exception($validator->errors()->first());
    
            $attributeValues=AttributeValue::
                where("id",$request->id)->
                where("attribute_id",$request->attribute_id)->
                first();
    
            if(!$attributeValues)
                throw new \Exception("Child attribute not found.");

            if(!$attributeValues->delete())
                throw new \Exception("Failed to delete the child attribute.");
    
            return response()->json(["message"=>"The child attribute deleted successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
}

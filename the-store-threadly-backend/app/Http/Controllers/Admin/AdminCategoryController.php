<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminCategoryController extends Controller
{
    public function index() :View
    {
        $categories= Category::
            with('parent')->
            get()->
            sortBy(function($category) {
                return $category->full_hierarchy;
            });
        return view("admin.category.index",compact("categories"));
    }
    public function category_section_table_view() :View
    {
        $categories= Category::
            with('parent')->
            get()->
            sortBy(function($category) {
                return $category->full_hierarchy;
            });
        return view("admin.category.table",compact("categories"));
    }
    public function category_section_select_view() :View
    {
        $categories=Category::orderBy("id","desc")->get();
        return view("admin.category.select",compact("categories"));
    }
    public function category_edit_view($id)
    {
        $category=Category::find($id);
        $categories=Category::orderBy("id","desc")->get();

        if(!$category)
            return redirect()->route("admin.category.view")->with("error","The category not found.");

        return view("admin.category.edit",compact("category","categories"));
    }

    public function category_store(Request $request) 
    {
        try{
            $validator = \Validator::make($request->all(),[
                "name"=>"required|string|unique:categories,name",
                "slug"=>"required|string|unique:categories,slug",
                "parent_id"=>"nullable|string|exists:categories,id",
            ]);

            if(!$validator->passes())
                return response()->json(["message"=>$validator->errors()->toArray()],422);
    
            $category=new Category();

            $category->name=$request->name;
            $category->slug=$request->slug;
            $category->parent_id=$request->parent_id;
    
            if(!$category->save())
                throw new \Exception("Failed to save category."); 
    
            return response()->json(["message"=>"Category added successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function category_update(Request $request) 
    {
        try{
            $validator = \Validator::make($request->all(),[
                "parent_id"=>"nullable|string|exists:categories,id",
                "name"=>[
                    "required",
                    "string",
                    Rule::unique("categories","name")->ignore($request->id)
                ],
                "slug"=>[
                    "required",
                    "string",
                    Rule::unique("categories","slug")->ignore($request->id)
                ],
            ]);

            if(!$validator->passes())
                return response()->json(["message"=>$validator->errors()->toArray()],422);
    
            $category=Category::find($request->id);

            if(!$category)
                throw new \Exception("Attribute not found.");

            $category->name=$request->name;
            $category->slug=$request->slug;
            $category->parent_id=$request->parent_id;
    
            if(!$category->save())
                throw new \Exception("Failed to update category."); 
    
            return response()->json(["message"=>"Attribute updated successfully.","redirect"=>route("admin.category.view")],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function category_status_update(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(),[
                "status" => "required|numeric|in:1,0",
            ]);
    
            if(!$validator->passes())
                throw new \Exception($validator->errors()->first());
    
            $category=Category::find($request->id);
    
            if(!$category)
                throw new Exception("Category not found.");
    
            $category->status=$request->status;
    
            if(!$category->save())
                throw new Exception("Failed to update category status.");
    
            return response()->json(["message"=>"Category status updated successfully."],200);
        }catch(Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function category_delete(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(), [
                "id" => "required|numeric|exists:categories,id",
            ]);
    
            if($validator->fails())
                throw new \Exception($validator->errors()->first());
    
            $category=Category::find($request->id);
    
            if(!$category)
                throw new \Exception("Category not found.");

            if(!$category->delete())
                throw new \Exception("Failed to delete the child category.");
    
            return response()->json(["message"=>"The category deleted successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Services\ImageService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminBlogController extends Controller
{
    public function index() :View
    {
        $blogs=Blog::orderBy("id","desc")->get();
        $categories=Category::orderBy("id","desc")->get();
        return view("admin.blog.index",compact("blogs","categories"));
    }
    public function blog_section_table_view() :View
    {
        $blogs=Blog::orderBy("id","desc")->get();
        return view("admin.blog.table",compact("blogs"));
    }
    public function blog_edit_view($blog_id)
    {
        $blog=Blog::find($blog_id);
        $categories=Category::orderBy("id","desc")->get();

        if(!$blog)
            return redirect()->route("admin.blog.view")->with("error","The blog not found.");

        if($categories->isEmpty())
            return redirect()->route("admin.product.view")->with("error","Please create at least one category before editing a product.");

        return view("admin.blog.edit",compact("blog","categories"));
    }


    public function blog_store(Request $request,ImageService $imageService) 
    {
        try{
            $validator = \Validator::make($request->all(),[
                "category_id"=>"required|numeric|exists:categories,id",
                "user_id"=>"required|numeric|exists:users,id",
                "image"=>"nullable|file|mimes:jpg,jpeg,png|max:1048576",
                "title"=>"required|string",
                "desc"=>"nullable|string",
                "seo_title"=>"nullable|string",
                "seo_desc"=>"nullable|string",
            ]);

            if(!$validator->passes())
                return response()->json(["message"=>$validator->errors()->toArray()],422);
    
            $blog=new Blog();
            $image = $imageService->uploadPhoto($request,null,"blog");
    
            $blog->category_id=$request->category_id;
            $blog->user_id=$request->user_id;
            $blog->image=$image;
            $blog->title=$request->title;
            $blog->desc=$request->desc;
            $blog->seo_title=$request->seo_title;
            $blog->seo_desc=$request->seo_desc;
    
            if(!$blog->save())
                throw new \Exception("Failed to save blog."); 
    
            return response()->json(["message"=>"Blog added successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function blog_update(Request $request,ImageService $imageService) 
    {
        try{
            $validator = \Validator::make($request->all(),[
                "category_id"=>"required|numeric|exists:categories,id",
                "user_id"=>"required|numeric|exists:users,id",
                "image"=>"nullable|file|mimes:jpg,jpeg,png|max:1024",
                "title"=>"required|string",
                "desc"=>"nullable|string",
                "seo_title"=>"nullable|string",
                "seo_desc"=>"nullable|string",
            ]);

            if(!$validator->passes())
                return response()->json(["message"=>$validator->errors()->toArray()],422);

            if (auth()->user()->id != $request->user_id)
                return response()->json(['message' => 'Unauthorized access.'], 403);
    
            $blog=Blog::find($request->id);

            if(!$blog)
                throw new \Exception("Blog not found."); 

            $image = $imageService->uploadPhoto($request,$blog,"blog");
    
            $blog->category_id=$request->category_id;
            $blog->user_id=$request->user_id;
            $blog->image=$image;
            $blog->title=$request->title;
            $blog->desc=$request->desc;
            $blog->seo_title=$request->seo_title;
            $blog->seo_desc=$request->seo_desc;
    
            if(!$blog->save())
                throw new \Exception("Failed to save blog."); 
    
            return response()->json(["message"=>"Blog updated successfully.","redirect"=>route("admin.blog.view")],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function blog_status_update(Request $request)
    {
        try{
            $validated = \Validator::make($request->all(),[
                'status_type' => 'required|string|in:status',
                'status_value' => 'required|boolean'
            ]);

            if($validated->fails())
                throw new \Exception($validated->errors()->first());
    
            $blog=Blog::find($request->id);
    
            if(!$blog)
                throw new \Exception("Blog not found.");
        
            if(!$blog->update([
                $request->status_type => $request->status_value
            ]))
                throw new \Exception("Failed to save status."); 
    
            return response()->json(["message"=>"Status updated successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
    public function blog_delete(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(), [
                "id" => "required|numeric|exists:blogs,id"
            ]);
    
            if($validator->fails())
	            throw new \Exception($validator->errors()->first());
    
            $blog=Blog::find($request->id);
    
            if(!$blog)
                throw new \Exception("Blog not found.");
    
            $blogImage=public_path("uploads/blog/").$blog->image;
            if($blog->image && file_exists($blogImage))
	            unlink($blogImage);

    
            if(!$blog->delete())
                    throw new \Exception("Failed to delete the blog.");
    
            return response()->json(["message"=>"Blog deleted successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
}

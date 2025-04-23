<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;

class FrontendBlogController extends Controller
{
    public function get_all () 
    {
        try{
            $blogs=Blog::
                where('status',1)->
                inRandomOrder()->
                get();
            
            return response()->json([
                "message"=>"Blogs retrieved successfully.",
                "data"=>BlogResource::collection($blogs),
            ],200);
        }catch(\Exception $err) {
            return response()->json(["message"=>$err->getMessage()], 500);
        }
    }
    public function get_one_by_slug ($slug) 
    {
        try{
            $blog= Blog::
                where("status",1)->
                where('slug', $slug)->
                firstOrFail();

            $relatedBlogs = Blog::
                where('status', 1)->
                where('id', '!=', $blog->id)->
                where('category_id', $blog->category_id)->
                inRandomOrder()->
                limit(12)->
                get();

            return response()->json([
                "message"=>"Product retrieved successfully.",
                "data"=>new BlogResource($blog),
                "dataRelated"=>BlogResource::collection($relatedBlogs),
            ],200);
        }catch(\Exception $err) {
            return response()->json(["message"=>$err->getMessage()], 500);
        }
    }
    public function get_by_filter(Request $request)
    {
        try{
            $category = $request->input('category'); 

            $blogsQuery=Blog::
                with(['category', 'user'])
                ->where('status',1);

            if ($category) {
                $blogsQuery->whereHas('category', function ($query) use ($category) {
                    $query->where('slug', $category);
                });
            }
    
            $blogs=$blogsQuery->latest()->paginate(6);
            
            return response()->json([
                "message"=>"Blogs retrieved successfully.",
                "data"=>BlogResource::collection($blogs),
                "meta" => [
                    "current_page" => $blogs->currentPage(),
                    "last_page" => $blogs->lastPage(),
                    "per_page" => $blogs->perPage(),
                    "total" => $blogs->total(),
                ]
            ],200);
        }catch(\Exception $err) {
            return response()->json(["message"=>$err->getMessage()], 500);
        }
    }
}

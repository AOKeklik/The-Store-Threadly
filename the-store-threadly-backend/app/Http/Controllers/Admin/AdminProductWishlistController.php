<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductWishlist;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminProductWishlistController extends Controller
{
    public function index() :View
    {
        $wishlists=ProductWishlist::orderBy("id","desc")->get();
        return view("admin.product-wishlist.index",compact("wishlists"));
    }
    public function section_table_view() :View
    {
        $wishlists=ProductWishlist::orderBy("id","desc")->get();
        return view("admin.product-wishlist.table",compact("wishlists"));
    }

    public function delete(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(), [
                "id" => "required|numeric|exists:blogs,id"
            ]);
    
            if($validator->fails())
                throw new \Exception($validator->errors()->first());
    
            $wishlist=ProductWishlist::find($request->id);
    
            if(!$wishlist)
                throw new \Exception("Wishlist not found.");
    
            if(!$wishlist->delete())
                throw new \Exception("Failed to delete the wishlist.");
    
            return response()->json(["message"=>"Wishlist deleted successfully."],200);
        }catch(\Exception $err){
            return response()->json(["message"=>$err->getMessage()],500);
        }
    }
}

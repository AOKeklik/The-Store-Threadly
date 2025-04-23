<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ProductWishlist;
use Illuminate\Http\Request;

class FrontendWishlistController extends Controller
{
    public function index()
    {
        try{
            $wishlists = ProductWishlist::
                with('product')
                ->where('user_id', 1)
                ->get();

            return response()->json([
                "message"=>"Wishlists retrieved successfully.",
                "data"=>$wishlists
            ],200);
        }catch(\Exception $err) {
            return response()->json(["message"=>$err->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
	            'product_id' => 'required|exists:products,id'
	        ]);

            $userId=1;

            $existing = ProductWishlist::where('user_id', $userId)
                ->where('product_id', $request->product_id)
                ->first();

            if ($existing) {
                return response()->json([
                    "message" => "Product is already in your wishlist.",
                    "data" => $existing
                ], 409);
            }

	        $wishlistItem = ProductWishlist::create([
	            'user_id' => $userId,
	            'product_id' => $request->product_id
	        ]);

            return response()->json([
                "message"=>"Wishlist created successfully.",
                "data"=>$wishlistItem
            ],201);
        }catch(\Exception $err) {
            return response()->json(["message"=>$err->getMessage()], 500);
        }
    }
    public function delete(Request $request)
    {
        try{
            $wishlistItem = ProductWishlist::
                where('user_id', 1)
	            ->where('id', $request->id)
	            ->firstOrFail();
	            
	        $wishlistItem->delete();

            return response()->json([
                "message"=>"Wishlist deleted successfully.",
                "data"=>null
            ],200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                "message" => "Wishlist item not found.",
                "data" => null
            ], 404);
        }catch(\Exception $err) {
            return response()->json(["message"=>$err->getMessage()], 500);
        }
    }
}

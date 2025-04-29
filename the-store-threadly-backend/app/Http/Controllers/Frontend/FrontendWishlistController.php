<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\WishlistResource;
use App\Models\ProductWishlist;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class FrontendWishlistController extends Controller
{
    public function index(Request $request)
    {
        $wishlists = ProductWishlist::
            with('product')
            ->where('user_id', $request->user()->id)
            ->get();

        return response()->json([
            "success" => true,
            "message"=>"Wishlists retrieved successfully.",
            "data"=> WishlistResource::collection($wishlists)
        ],200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_variant_id' => 'required|exists:product_variants,id'
        ]);

        $existing = ProductWishlist::where('user_id', $request->user()->id)
            ->where('product_id', $request->product_id)
            ->where('product_variant_id', $request->product_variant_id)
            ->first();

        if ($existing) {
            return response()->json([
                "success" => false,
                "message" => "Product is already in your wishlist.",
                "data" => $existing
            ], 409);
        }

        $wishlistItem = ProductWishlist::create([
            'user_id' => $request->user()->id,
            'product_id' => $request->product_id,
            'product_variant_id' => $request->product_variant_id
        ]);

        return response()->json([
            "success" => true,
            "message"=>"Wishlist created successfully.",
            "data"=> new WishlistResource($wishlistItem)
        ],201);      
    }
    public function delete(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'product_variant_id' => 'required|integer|exists:product_variants,id'
        ]);

        $wishlistItem = ProductWishlist::
            where('user_id', $request->user()->id)
            ->where('product_id', $request->product_id)
            ->where('product_variant_id', $request->product_variant_id)
            ->first();

        if (!$wishlistItem) {
            return response()->json([
                "success" => false,
                "message" => "Wishlist item not found.",
                "error_type" => "wishlist_item_not_found"
            ], 409);
        }
            
        $wishlistItem->delete();

        return response()->json([
            "success" => true,
            "message"=>"Wishlist deleted successfully.",
            "data"=> new WishlistResource($wishlistItem)
        ],200);
    }
    public function clear(Request $request)
    {
        $wishlistItes = ProductWishlist::where('user_id', $request->user()->id);

        if (!$wishlistItes->exists()) {
            return response()->json([
                "success" => false,
                "error_type" => "credential",
                "message" => "No items found in the wishlist.",
                "error" => "wishlist_empty",
            ], 404);
        }
            
        $wishlistItes->delete();

        return response()->json([
            "success" => true,
            "message"=>"Wishlist cleared successfully.",
            "data"=>null
        ],200);
    }
}

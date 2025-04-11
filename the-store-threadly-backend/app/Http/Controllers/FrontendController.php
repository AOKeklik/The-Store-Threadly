<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function product_get_all () {
        return ProductResource::collection(
            Product::
                with('variants',"galeries")->
                latest()->
                get()
        );
    }

    public function product_get_one_by_slug ($id,$slug) 
    {
        return ProductResource::make(
            Product::
                with('variants',"galeries")->
                where('id', $id)->
                where('slug', $slug)->
                firstOrFail()
        );
    }


    public function product_filter(Request $request)
    {
        $color = $request->query('color');
        $size = $request->query('size');

        $products = Product::with(['variants', 'galeries'])
            ->when($color, function ($query) use ($color) {
                $attribute = Attribute::where('name', 'color')->first();
                $value = AttributeValue::where('id', $color)->first();
                if ($attribute && $value) {
                    $query->whereHas('variants', function ($q) use ($attribute, $value) {
                        $q->whereJsonContains("attribute_value_ids->{$attribute->id}", $value->id);
                    });
                }
            })
            ->when($size, function ($query) use ($size) {
                $attribute = Attribute::where('name', 'size')->first();
                $value = AttributeValue::where('id', $size)->first();
                if ($attribute && $value) {
                    $query->whereHas('variants', function ($q) use ($attribute, $value) {
                        $q->whereJsonContains("attribute_value_ids->{$attribute->id}", $value->id);
                    });
                }
            })
            ->get();

        return $products->isEmpty()
            ? response()->json(['message' => 'No products found for the selected filters.'], 404)
            : ProductResource::collection($products);
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'desc' => $this->desc,
            'price' => $this->price,
            'offer_price' => $this->offer_price,
            'stock' => $this->stock(),
            'reviews' => $this->reviews,
            'thumbnail' => $this->image(),
            'galeries' => GaleryResource::collection($this->galeries),
            'variants' => VariantResource::collection($this->variants),
            'status' => $this->status,
        //     'colors' => $this->colors,
        //     'sizes' => $this->sizes,
        //     'first_image' => $this->first_image ? asset($this->first_image) : null,
        //     'second_image' => $this->second_image ? asset($this->second_image) : null,
        //     'third_image' => $this->third_image ? asset($this->third_image) : null,
        ];
    }
}

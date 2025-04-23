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
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'desc' => $this->desc,
            'short_desc' => $this->short_desc,
            'price' => $this->price,
            'price_html' => $this->getPrice(),
            'offer_price' => $this->offer_price,
            'stock' => $this->stock,
            'reviews' => $this->reviews,
            'review_count' => $this->reviews->count(),
            'thumbnail' => $this->getImage(),
            'cover' => $this->getCover(),
            'galleries' => GaleryResource::collection($this->galeries),
            'variants' => VariantResource::collection($this->variants),
            'category' =>new  CategoryResource($this->category),
            'gender' => $this->gender,
            'is_new' => $this->is_new,
            'is_featured' => $this->is_featured,
            'is_best_seller' => $this->is_bestseller,
        ];
    }
}

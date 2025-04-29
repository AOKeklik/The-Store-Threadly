<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WishlistResource extends JsonResource
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
            'productId' => $this->product_id,
            'variantId' => $this->product_variant_id,
            'title' => $this->product->title,
            'slug' => $this->product->slug,
            'price' => $this->productVariant->offer_price ?? $this->productVariant->price,
            'stock' => $this->productVariant->stock,
            'thumbnail' => $this->productVariant->getImage(),
            'gender' => $this->product->gender,
        ];
    }
}

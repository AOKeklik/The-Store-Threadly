<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VariantResource extends JsonResource
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
            'price' => $this->price,
            'offer_price' => $this->offer_price,
            'price_html' => $this->getPrice(),
            'stock' => $this->stock,
            'thumbnail' => $this->getImage(),
            'attributes' => AttributeValueResource::collection($this->attributeValues),
            'galleries' => GaleryResource::collection($this->galeries),
        ];
    }
}

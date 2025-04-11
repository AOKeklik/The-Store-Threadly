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
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'price' => $this->price,
            'offer_price' => $this->offer_price,
            'stock' => $this->stock(),
            'thumbnail' => $this->image(),
            'attributes' => $this->attributes_info,
            'status' => $this->status,
        ];
    }
}

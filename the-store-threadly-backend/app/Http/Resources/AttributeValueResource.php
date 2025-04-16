<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeValueResource extends JsonResource
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
            'slug' => $this->slug,
            'value' => $this->value,
            'icon' => $this->icon,
            'attribute' => [
                'id' => $this->attribute->id,
                'slug' => $this->attribute->slug,
                'name' => $this->attribute->name,
            ],
        ];
    }
}

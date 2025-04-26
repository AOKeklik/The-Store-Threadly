<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'desc' => $this->desc,
            'seo_title' => $this->seo_title,
            'seo_desc' => $this->seo_desc,
            'image' => $this->getImage(),
            'cover' => $this->getCover(),
        ];
    }
}

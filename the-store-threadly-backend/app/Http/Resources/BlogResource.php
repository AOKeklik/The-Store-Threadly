<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'category' => [
                "id" => $this->category->id,
                "slug" => $this->category->slug,
                "name" => $this->category->name,
            ],
            'author' => $this->user->name,
            'slug' => $this->slug,
            'thumbnail' => $this->getImage(),
            'excerpt' => \Illuminate\Support\Str::limit(strip_tags($this->desc), 150),
            'title' => $this->title,
            'desc' => $this->desc,
            'seo_title' => $this->seo_title,
            'seo_desc' => $this->seo_desc,
            'created_date' => $this->created_at->format('F, Y'),
            'created_day' => $this->updated_at->format('m'),
        ];
    }
}

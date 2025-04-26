<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable  = [
        "type",
        "slug",
        "image",
        "cover",
        "title",
        "desc",
        "seo_title",
        "seo_desc",
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($page) {
            if (!empty($page->title)) {
                $page->slug = \Illuminate\Support\Str::slug($page->title);
            }
        });
    }

    public function getImage()
    {
        if($this->image)
            return asset("uploads/".$this->type."/".$this->image);
        
        return "https://placehold.co/600x400?text=Hello+World";
    }

    public function getCover()
    {
        if($this->cover)
            return asset("uploads/".$this->type."/".$this->cover);
        
        return "https://placehold.co/1200x400?text=Hello+World";
    }
}

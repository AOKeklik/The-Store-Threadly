<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $guarded  = [];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            $blog->slug = \Illuminate\Support\Str::slug($blog->title);
        });

        static::updating(function ($blog) {
            $blog->slug = \Illuminate\Support\Str::slug($blog->title);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImage()
    {
        if($this->image)
            return asset("uploads/blog/".$this->image);
        
        return "https://placehold.co/600x400?text=Hello+World";
    }

    public function getCover()
    {
        if($this->cover)
            return asset("uploads/blog-cover/".$this->cover);
        
        return "https://placehold.co/1200x400?text=Hello+World";
    }
}

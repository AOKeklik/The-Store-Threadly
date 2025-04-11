<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $guarded  = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function galeries()
    {
        return $this->hasMany(ProductGalery::class);
    }

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->
            with('user')->
            where('status',1)->
            latest();
    }

    public function image()
    {
        if($this->image)
            return asset("uploads/product/".$this->image);
        
        return "https://placehold.co/600x400?text=Hello+World";
    }

    public function stock()
    {
        return is_null($this->stock) || $this->stock <= 0
            ? 'Out of stock'
            : $this->stock . ' in stock';
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
            if (!empty($product->title)) {
                $product->slug = Str::slug($product->title);
            }

            if(!empty($product->sku)) {
                $product->sku = strtoupper(Str::slug($product->sku));
            }
        });
    }
}

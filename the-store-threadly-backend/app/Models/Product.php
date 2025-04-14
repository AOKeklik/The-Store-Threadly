<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded  = [];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
            if (!empty($product->title)) {
                $product->slug = \Illuminate\Support\Str::slug($product->title);
            }

            if(!empty($product->sku)) {
                $product->sku = strtoupper(\Illuminate\Support\Str::slug($product->sku));
            }
        });
    }

    protected static function booted()
    {
        static::saving(function ($product) {
            if ($product->is_new && $product->created_at->diffInDays(now()) > 30) {
                $product->is_new = false;
            }
        });
    }

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
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->
            with('user')->
            where('status',1)->
            latest();
    }

    public function getImage()
    {
        if($this->image)
            return asset("uploads/product/".$this->image);
        
        return "https://placehold.co/600x400?text=Hello+World";
    }

    public function getPrice()
    {
        $currencyIcon = setting('site_currency_icon'); 
        $currencyPosition = setting('site_currency_icon_position');
    
        if ($currencyPosition === 'right')
            return $currencyIcon . ' ' . $this->price;
    
        return $this->price . ' ' . $currencyIcon;
    }

    public function getStock()
    {
        return is_null($this->stock) || $this->stock <= 0
            ? 'Out of stock'
            : $this->stock . ' in stock';
    }
}

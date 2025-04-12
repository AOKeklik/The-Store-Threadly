<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $guarded  = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attributeValues()
    {
        return $this->belongsToMany(
            AttributeValue::class,
            'product_variant_attribute_values',
            'variant_id',
            'attribute_value_id'
        )
        ->with('attribute');
    }

    public static function getCommonAttributes()
    {
        $attributeNames = ProductVariant::with('attributeValues.attribute')
            ->get()
            ->flatMap(function ($variant) {
                return $variant->attributeValues->pluck('attribute.name');
            });
        return $attributeNames->countBy()->sortDesc()->keys();
    }

    public function getOrderedAttributeValues()
    {
        return $this->attributeValues->sortBy('attribute_id');
    }

    public function getPrice()
    {
        $currencyIcon = setting('site_currency_icon'); 
        $currencyPosition = setting('site_currency_icon_position');
    
        if ($currencyPosition === 'right')
            return $currencyIcon . ' ' . $this->price;
    
        return $this->price . ' ' . $currencyIcon;
    }

    public function getImage()
    {
        if($this->image)
            return asset("uploads/variant/".$this->image);
        
        return "https://placehold.co/600x400?text=Hello+World";
    }

    public function getStock()
    {
        return is_null($this->stock) || $this->stock <= 0
            ? 'Out of stock'
            : $this->stock . ' in stock';
    }
}

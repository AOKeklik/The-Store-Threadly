<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($attributeValue) {
            if (!empty($attributeValue->value)) {
                $attributeValue->slug = \Illuminate\Support\Str::slug($attributeValue->value);
            }
        });
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
    
    public function variants()
    {
        return $this->belongsToMany(
            \App\Models\ProductVariant::class,
            'product_variant_attribute_values',
            'attribute_value_id',
            'variant_id'
        );
    }
    
    public function getIcon()
    {
        if (preg_match('/^#([A-Fa-f0-9]{3}){1,2}$/', $this->icon)) {
            return '<span class="badge"style="display:inline-block;width:18px;height:18px;border-radius:4px;background-color:' . $this->icon . ';border:1px solid #333;"></span>';
        }

        return '<span class="badge badge-primary" style="padding:4px 8px;border-radius:4px;font-size:12px;">' . e($this->icon) . '</span>';
    }
}

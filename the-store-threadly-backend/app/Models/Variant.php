<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;

    protected $guarded  = [];

    protected $casts = [
        'attribute_value_ids' => 'array',
    ];

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class, 'attribute_id');
    }

    public function price()
    {
        $currencyIcon = setting('site_currency_icon'); 
        $currencyPosition = setting('site_currency_icon_position');
    
        if ($currencyPosition === 'right')
            return $currencyIcon . ' ' . $this->price;
    
        return $this->price . ' ' . $currencyIcon;
    }

    public function image()
    {
        if($this->image)
            return asset("uploads/variant/".$this->image);
        
        return "https://placehold.co/600x400?text=Hello+World";
    }

    public function stock()
    {
        return is_null($this->stock) || $this->stock <= 0
            ? 'Out of stock'
            : $this->stock . ' in stock';
    }

    public function getAttributesInfoAttribute()
    {
        $attributesInfo = [];

        foreach ($this->attribute_value_ids ?? [] as $attributeId => $valueId) {
            $attribute = \App\Models\Attribute::find($attributeId);
            $value = \App\Models\AttributeValue::find($valueId);

            if ($attribute && $value) {
                $attributesInfo[] = [
                    'id' => $attribute->id,
                    'key' => $attribute->name,
                    'value' => $value->value,
                    'icon' => $value->icon(),
                ];
            }
        }

        return $attributesInfo;
    }


    public function getAttributeValueByAttributeId($attributeId)
    {
        $values = $this->attribute_value_ids;    
        $valueId = $values[$attributeId] ?? null;
    
        return $valueId
            ? AttributeValue::find($valueId)
            : null;
    }

    public function setAttributeValueIdsAttribute($value)
    {
        if (!is_array($value))
            $value = [];
    
        $filtered = [];
    
        foreach ($value as $key => $val)
            if (is_numeric($val))
                $filtered[$key] = (int)$val;
    
        $this->attributes['attribute_value_ids'] = json_encode($filtered);
    }
}

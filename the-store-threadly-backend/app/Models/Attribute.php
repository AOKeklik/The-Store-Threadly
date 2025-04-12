<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $guarded  = [];
    
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($attribute) {
            if (!empty($attribute->name)) {
                $attribute->slug = \Illuminate\Support\Str::slug($attribute->name);
            }
        });
    }
    
    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }
}

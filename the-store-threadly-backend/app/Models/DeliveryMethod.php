<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'company',
        'desc',
        'price',
        'type',
        'code',
        'status'
    ];

    protected $casts = [
        'code' => 'boolean',
        'status' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($delivery) {
            
            if (!empty($delivery->name))
                $delivery->slug = \Illuminate\Support\Str::slug($delivery->name);
        });
    }

    public function getCodeValueAttribute()
    {
        return $this->code ? setting("site_delivery_code_amount") : 0;
    }
}

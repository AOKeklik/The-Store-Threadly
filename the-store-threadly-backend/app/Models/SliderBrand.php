<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SliderBrand extends Model
{
    use HasFactory;

    public function getImage()
    {
        if($this->image)
            return asset("uploads/slider-brand/".$this->image);
        
        return "https://placehold.co/600x400?text=Hello+World";
    }
}

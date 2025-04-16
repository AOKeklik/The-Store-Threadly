<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantGalery extends Model
{
    use HasFactory;

    protected $guarded  = [];

    public function getImage()
    {
        if($this->image)
            return asset("uploads/variant-galery/".$this->image);
        
        return "https://placehold.co/600x400?text=Hello+World";
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerData extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'country',
        'state',
        'city',
        'zip',
        'address',
    ];

    public function getCountryAttribute($value)
    {
        return $value ?? 'Polska';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImage()
    {
        if($this->user->image)
            return asset("uploads/customer/".$this->user->image);
        
        return "https://cdn.pixabay.com/photo/2017/11/10/05/48/user-2935527_1280.png";
    }
}

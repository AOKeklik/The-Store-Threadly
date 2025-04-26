<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'email',
        'subject',
        'message',
        'is_viewed',
    ];

    public function scopeUnread($query)
    {
        return $query->where('is_viewed', 0);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'ip',
        'is_viewed',
        'status',
    ];

    public function scopeUnread($query)
    {
        return $query->where('is_viewed', 0);
    }
}

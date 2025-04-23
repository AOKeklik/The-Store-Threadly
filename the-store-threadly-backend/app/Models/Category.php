<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($category) {
            
            if (!empty($category->name))
                $category->slug = \Illuminate\Support\Str::slug($category->name);
        });
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function getDepthAttribute()
    {
        $depth = 0;
        $current = $this->parent;
        
        while ($current) {
            $depth++;
            $current = $current->parent;
        }
        
        return $depth;
    }

    public function getFullHierarchyAttribute()
    {
        if (!$this->parent) {
            return $this->name;
        }

        $hierarchy = [];
        $current = $this;
        
        do {
            array_unshift($hierarchy, $current->name);
            $current = $current->parent;
        } while ($current);

        return implode(' > ', $hierarchy);
    }
}

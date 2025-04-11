<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value'];

    public static function setValue($key, $value)
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
        cache()->forget("setting_{$key}");
    }
    public static function getValue($key)
    {
        return cache()->rememberForever("setting_{$key}", function () use ($key) {
            return self::where('key', $key)->value('value');
        });
    }
    public static function allSettings()
    {
        return cache()->rememberForever('settings_all', function () {
            return self::pluck('value', 'key')->toArray();
        });
    }
    public static function clearCache()
    {
        cache()->flush();
    }
}

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
            $settings = self::pluck('value', 'key')->toArray();

            // Favicon URL
            $settings['site_favicon_url'] = $settings['site_favicon']
                ? asset('uploads/setting/' . $settings['site_favicon'])
                : 'https://placehold.co/32x32?text=Favicon';

            // Logo URL
            $settings['site_logo_url'] = $settings['site_logo']
                ? asset('uploads/setting/' . $settings['site_logo'])
                : 'https://placehold.co/150x50?text=Logo';

            return $settings;
        });
    }
    public static function clearCache()
    {
        cache()->flush();
    }
}

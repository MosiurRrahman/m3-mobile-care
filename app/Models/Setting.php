<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Cache key constant.
     */
    const CACHE_KEY = 'm3_all_settings_cache';
    const CACHE_TTL = 86400; // 24 hours

    /**
     * In-memory runtime cache to avoid multiple Cache store hits in the same request.
     */
    protected static array $runtimeCache = [];

    /**
     * Get a setting by key with caching.
     */
    public static function get($key, $default = null)
    {
        if (isset(self::$runtimeCache[$key])) {
            return self::$runtimeCache[$key];
        }

        $allSettings = Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return self::pluck('value', 'key')->toArray();
        });

        if (is_array($allSettings) && array_key_exists($key, $allSettings)) {
            self::$runtimeCache[$key] = $allSettings[$key];
            return $allSettings[$key];
        }

        return $default;
    }

    /**
     * Set a setting key to value and flush cache.
     */
    public static function set($key, $value)
    {
        $result = self::updateOrCreate(['key' => $key], ['value' => $value]);
        self::flushCache();
        return $result;
    }

    /**
     * Clear the settings cache.
     */
    public static function flushCache(): void
    {
        self::$runtimeCache = [];
        Cache::forget(self::CACHE_KEY);
    }
}

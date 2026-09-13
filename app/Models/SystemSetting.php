<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SystemSetting extends Model
{
    protected $fillable = ['key', 'value'];

    private static ?array $runtimeCache = null;

    public static function allKeyValues(): array
    {
        if (static::$runtimeCache !== null) {
            return static::$runtimeCache;
        }

        return static::$runtimeCache = Cache::remember('system_settings_all', 3600, function () {
            try {
                return static::pluck('value', 'key')->toArray();
            } catch (\Throwable $e) {
                return [];
            }
        });
    }

    public static function get(string $key, $default = null)
    {
        $all = static::allKeyValues();
        return array_key_exists($key, $all) ? $all[$key] : $default;
    }

    public static function set(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        static::$runtimeCache = null;
        Cache::forget('system_settings_all');
    }
}

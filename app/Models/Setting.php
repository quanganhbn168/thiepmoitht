<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
    ];

    /**
     * Get a setting value by key
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = Cache::remember("setting.{$key}", 3600, function () use ($key) {
            return static::where('key', $key)->first();
        });

        if (!$setting) {
            return $default;
        }

        return match ($setting->type) {
            'integer' => (int) $setting->value,
            'boolean' => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
            'json' => json_decode($setting->value, true),
            default => $setting->value,
        };
    }

    /**
     * Set a setting value
     */
    public static function set(string $key, mixed $value, string $type = 'string'): void
    {
        $storedValue = match ($type) {
            'json' => json_encode($value),
            'boolean' => $value ? '1' : '0',
            default => (string) $value,
        };

        static::updateOrCreate(
            ['key' => $key],
            ['value' => $storedValue, 'type' => $type]
        );

        Cache::forget("setting.{$key}");
    }

    /**
     * Get all settings by group
     */
    public static function getByGroup(string $group): array
    {
        return static::where('group', $group)
            ->get()
            ->mapWithKeys(fn($s) => [$s->key => static::get($s->key)])
            ->toArray();
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache(): void
    {
        $keys = static::pluck('key');
        foreach ($keys as $key) {
            Cache::forget("setting.{$key}");
        }
    }

    // ===================================================
    // PRICING HELPERS
    // ===================================================

    /**
     * Get retail tier price
     */
    public static function getTierPrice(string $tier): int
    {
        return match ($tier) {
            'basic' => static::get('price_basic', 198000),
            'standard' => static::get('price_standard', 299000),
            'pro' => static::get('price_pro', 499000),
            default => 0,
        };
    }

    /**
     * Get agent plan price
     */
    public static function getAgentPrice(string $plan): int
    {
        return match ($plan) {
            'basic' => static::get('agent_price_basic', 199000),
            'standard' => static::get('agent_price_standard', 499000),
            'enterprise' => static::get('agent_price_enterprise', 999000),
            default => 0,
        };
    }

    /**
     * Get agent quota
     */
    public static function getAgentQuota(string $plan): int
    {
        return match ($plan) {
            'trial' => 5,
            'basic' => static::get('agent_quota_basic', 10),
            'standard' => static::get('agent_quota_standard', 30),
            'enterprise' => -1, // Unlimited
            default => 0,
        };
    }

    /**
     * Get tier max photos
     */
    public static function getTierMaxPhotos(string $tier): int
    {
        return match ($tier) {
            'basic' => static::get('photos_basic', 20),
            'standard' => static::get('photos_standard', 40),
            'pro' => -1, // Unlimited
            default => 20,
        };
    }

    /**
     * Get tier expiry in months
     */
    public static function getTierExpiry(string $tier): ?int
    {
        return match ($tier) {
            'basic' => static::get('expires_basic', 6),
            'standard' => static::get('expires_standard', 12),
            'pro' => null, // Vĩnh viễn
            default => 6,
        };
    }

    /**
     * Format price for display
     */
    public static function formatPrice(int $price): string
    {
        if ($price >= 1000000) {
            return number_format($price / 1000000, 1) . 'M';
        }
        return number_format($price / 1000) . 'K';
    }
}

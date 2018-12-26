<?php

namespace Ofcold\Configurations;

use Illuminate\Support\Facades\Cache;

/**
 * Class Repository
 *
 * @link     https://ofcold.com
 *
 * @author   Bill Li (bill.li@ofcold.com)
 */
class Repository
{
    /**
     * Find configuration items.
     *
     * @return array
     */
    public static function items()
    {
        return Cache::rememberForever(env('OFCOLD_CONFIGURATION_KEY', 'ofcold_configurations'), function() {
            return ConfigurationModel::get();
        });
    }

    /**
     * Find scope configurations.
     *
     * @param  string $scope
     *
     * @return array|null
     */
    public static function scopeItems(string $scope)
    {
        return static::items()->filter(function($item) use ($scope) {
            return $item->getScope() === $scope;
        });
    }

    /**
     * Get a configuration.
     *
     * @param $key
     *
     * @return ConfigurationModel|null
     */
    public static function get(string $key)
    {
        return static::items()->filter(function($item) use ($key) {
            return $item->getKey() === $key;
        })->first();
    }

    /**
     * Get a configuration.
     *
     * @param $key
     *
     * @return string|null
     */
    public static function getValue(string $key)
    {
        return optional(static::get($key))->getValue();
    }

}

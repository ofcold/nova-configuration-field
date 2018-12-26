<?php

namespace Ofcold\Configurations;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ConfigurationModel
 *
 * @link     https://ofcold.com
 *
 * @author   Bill Li (bill.li@ofcold.com)
 */
class ConfigurationModel extends Model
{
    /**
     * The database table.
     *
     * @var string
     */
    protected $table = 'configurations';

    public $timestamps = false;

    /**
     * Get the key.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set the key.
     *
     * @param $key
     *
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get the scope.
     *
     * @return mixed
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Set the scope.
     *
     * @param $scope
     *
     * @return $this
     */
    public function setScope($scope)
    {
        $this->scope = $scope;

        return $this;
    }

    /**
     * Get the value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value.
     *
     * @param $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Find a configuration by it's key or return a new instance.
     *
     * @param $key
     * @param $scope
     *
     * @return self
     */
    public static function findByKeyAndScopeOrNew(string $key, string $scope)
    {
        if (!$configuration = static::where('key', $key)->where('scope', $scope)->first()) {

            $configuration = new static;

            $configuration->setKey($key);
            $configuration->setScope($scope);
        }

        return $configuration;
    }

    /**
     * Get a configuration value.
     *
     * @param  string $key
     *
     * @return ConfigurationModel|null
     */
    public static function getItem(string $key)
    {
        return static::where('key', $key)->first();
    }

    /**
     * Set a configurations value.
     *
     * @param string $key
     * @param string $scope
     * @param mixed $value
     */
    public static function setItem(string $key, string $scope, $value)
    {
        $configuration = static::findByKeyAndScopeOrNew($key, $scope);

        $configuration->setValue($value);

        $configuration->save();
    }
}

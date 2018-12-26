<?php

namespace Ofcold\Configurations;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

/**
 * Class Configurations
 *
 * @link     https://ofcold.com
 *
 * @author     Bill Li (bill.li@ofcold.com)
 */
class Configurations extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'configurations';

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

    /**
     * Indicates if the element should be shown on the detail view.
     *
     * @var bool
     */
    public $showOnDetail = false;

    /**
     * Polymorphic constructor.
     *
     * @param string $name
     * @param null $attribute
     */
    public function __construct($name, $attribute = null)
    {
        parent::__construct($name, $attribute);
    }

    public function setConfigurations(array $fields, string $scope)
    {
        return $this->withMeta([
            'configurations' => [
                'scope' => $scope,
                'value' => Configurationmodel::class,
                'fields' => $fields
            ],
        ]);
    }

    /**
     * Retrieve values of dependency fields
     *
     * @param mixed $model
     * @param string $attribute
     *
     * @return array|mixed
     */
    protected function resolveAttribute($model, $attribute)
    {
        $config = $this->meta['configurations'];

        $key = $config['scope'] ? $config['scope'] . '::' : '';

        foreach ($config['fields'] as $field) {
            $attribute = Arr::get($field->jsonSerialize(), 'attribute');
            $field->resolve(
                ConfigurationModel::getItem($key . $attribute),
                'value'
            );
        }
    }

    /**
     * Fills the attributes of the model within the container if the dependencies for the container are satisfied.
     *
     * @param NovaRequest $request
     * @param string $requestAttribute
     * @param object $model
     * @param string $attribute
     */
    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        $config = $this->meta['configurations'];

        $key = $config['scope'] ? $config['scope'] . '::' : '';

        foreach ($config['fields'] as $field) {

            $attribute = Arr::get($field->jsonSerialize(), 'attribute');

            ConfigurationModel::setItem($key . $attribute, $config['scope'], $request->input($attribute));
        }

        // Clear cache items.
        Cache::forget(env('OFCOLD_CONFIGURATION_KEY', 'ofcold_configurations'));

    }
}

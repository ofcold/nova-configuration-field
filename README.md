# nova-configuration-field
Dynamically create configuration items for your resources.

## Requirements

Laravel Nova.

# Installation

First install the Nova package via composer:

```bash
composer require ofcold/ofcold/nova-configurations-field
```

Publish the config file:

```bash
php artisan vendor:publish --provider="Ofcold\\Configurations\\FieldServiceProvider"
```

Then run the migration
```bash
php artisan migrate
```

# Usage

Add configuration item cache key in your `.env` File
```bash
OFCOLD_CONFIGURATION_KEY=config
```

Configure different resources
```php

use Ofcold\Configurations\Configurations;

/**
 * Get the fields displayed by the resource.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return array
 */
public function fields(Request $request)
{
    return [
        ID::make()->sortable(),
        Configurations::make('Configurations')
            ->setConfigurations([
                Text::make('foo'),
                Text::make('bar')
            ], 'example')
    ];
}

```

Get configuration item from scope
```php

use Ofcold\Configurations\Repository;

Repository::scopeItems($scope)

```

Get a single configuration
```php

use Ofcold\Configurations\Repository;
// Use scope and key
// Example: example::foo
Repository::get('example::foo')

```

Get a single configuration value
```php

use Ofcold\Configurations\Repository;
// Use scope and key
// Example: example::foo
Repository::getValue('example::foo')

```

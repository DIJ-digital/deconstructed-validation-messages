# deconstructed-validation-messages

This package makes Laravel return validation messages in a deconstructed way. Instead of simply returning strings. This way your frontend can easily display the messages in a more user-friendly way.

## Installation

You can install the package via composer:

```bash
composer require dij-digital/deconstructed-validation-messages
```

Optionally you can publish the config file with:

```bash
php artisan vendor:publish --tag="deconstructed-validation-messages-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

Simply install the package and make sure the Provider is registered. The package will automatically take care of the rest.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [DIJ](https://github.com/DIJ-Digital)

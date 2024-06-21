# deconstructed-validation-messages

Is your application headless or an API? Do you want *all* your translations to be done in the frontend? Then this is the package for you. Instead of returning the translated error strings from the Laravel translation files, this package returns the original translation keys, the parameters and their values.

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

Simply install the package and make sure the provider is registered. The package will automatically take care of the rest.

Your response will look like this:

```json
{
  "field": {
    "rule": {
      "key": "rule.language_key",
      "message": "Traditional error message",
      "parameters": {
        "x": 1,
        "y": 2
      }
    }
  }
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [DIJ](https://github.com/DIJ-Digital)

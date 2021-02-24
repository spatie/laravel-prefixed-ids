# Friendly prefixed IDs for Laravel models

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-prefixed-ids.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-prefixed-ids)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/spatie/laravel-prefixed-ids/run-tests?label=tests)](https://github.com/spatie/laravel-prefixed-ids/actions?query=workflow%3ATests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/spatie/laravel-prefixed-ids/Check%20&%20fix%20styling?label=code%20style)](https://github.com/spatie/laravel-prefixed-ids/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-prefixed-ids.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-prefixed-ids)

This package can generate friendly prefixed ids for Eloquent models. For example:

```
user_fj39fj3lsmxlsl
test_token_dvklms109dls
```

The package can retrieve the model for a given prefixed id.

```php
// on a specific model
User::findByPrefixedId('user_fj39fj3lsmxlsl'); // returns a User model or `null`

// automatically determine the model of a given prefixed id
$user = PrefixedIds::getModel('user_fj39fj3lsmxlsl') // returns the right model for the id or `null`;
```

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/package-laravel-prefixed-ids-laravel.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/package-laravel-prefixed-ids-laravel)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/laravel-prefixed-ids
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Spatie\PrefixedIds\PrefixedIdsServiceProvider" --tag="laravel-prefixed-ids-config"
```

This is the contents of the published config file:

```php
return [
    /*
     * The delimiter used for glue the prefixed part with the unique part of an id
     */
    'glue' => '_',
];
```

## Usage

Coming soon

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

This package is inspired by [excid3/prefixed_ids](https://github.com/excid3/prefixed_ids)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

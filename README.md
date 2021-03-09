# Friendly prefixed IDs for Laravel models

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-prefixed-ids.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-prefixed-ids)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/spatie/laravel-prefixed-ids/run-tests?label=tests)](https://github.com/spatie/laravel-prefixed-ids/actions?query=workflow%3ATests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/spatie/laravel-prefixed-ids/Check%20&%20fix%20styling?label=code%20style)](https://github.com/spatie/laravel-prefixed-ids/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-prefixed-ids.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-prefixed-ids)

Prefixing an id will help users to recognize what kind of id it is. Stripe does this by default: customer ids are prefixed with `cus`, secret keys in production are prefixed with `sk_live_`, secret keys of a testing environment with `sk_test_` [and so on...](https://gist.github.com/fnky/76f533366f75cf75802c8052b577e2a5).

This package can generate such friendly prefixed ids for Eloquent models. Here's how such generated ids could look like.

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

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-prefixed-ids.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-prefixed-ids)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/laravel-prefixed-ids
```

### Preparing your models

On each model that needs a prefixed id, you should use the `Spatie\PrefixedIds\Models\Concerns\HasPrefixedId` trait.

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

class YourModel extends Model
{
    use HasPrefixedId;
}
```

### Preparing the database

For each model that needs a prefixed id, you'll need to write a migration to add a `prefixed_id` column to its underlying table.

If you wish to use another attribute name, you should publish the config file (see below) and set the `prefixed_id_attribute_name` config value to the attribute name of your liking.

```php
Schema::create('your_models_table', function (Blueprint $table) {
   $table->string('prefixed_id')->nullable()->unique();
});
```

### Registering models with prefixed ids

To register your models, you should pass the desired prefix and the class name of your model to `PrefixedIds::registerModels`.

```php
Spatie\PrefixedIds\PrefixedIds::registerModels([
    'your_prefix_' => YourModel::class,
    'another_prefix' => AnotherModel::class,
]);
```

Typically, you would put the code above in a service provider.

### Publish the config file

Optionally, You can publish the config file with:
```bash
php artisan vendor:publish --provider="Spatie\PrefixedIds\PrefixedIdsServiceProvider" --tag="laravel-prefixed-ids-config"
```

This is the contents of the published config file:

```php
return [
    /*
     * The attribute name used to store prefixed ids on a model
     */
    'prefixed_id_attribute_name' => 'prefixed_id',

    /*
     * UUID's are used by default. Setting this to true will use ordered UUID's instead.
     */
    'use_ordered_uuids' => false,
];
```

Instead of using UUID's, you can use ordered UUID's. Ordered UUID's are sortable by default; they switch the hash and the timestamp.

Read more about the (security) differences between UUIDv4 and ordered UUID's [here](https://itnext.io/laravel-the-mysterious-ordered-uuid-29e7500b4f8)

## Usage

When a model is created, it will automatically have a unique, prefixed id in the `prefixed_id` attribute.

```php
$model = YourModel::create();
$model->prefixed_id // returns a random id like `your_model_fekjlmsme39dmMS`
```

### Finding a specific model

You can find the model with a given prefix by calling `findByPrefixedId` on it.

```php
YourModel::findByPrefixedId('your_model_fekjlmsme39dmMS'); // returns an instance of `YourModel`
YourModel::findByPrefixedId('non-existing-id'); // returns null
```

### Finding across models

You can call `find` on `Spatie\PrefixedIds\PrefixedIds` to automatically get the right model for any given prefixed id.

```php
$yourModel = Spatie\PrefixedIds\PrefixedIds::find('your_model_fekjlmsme39dmMS'); // returns an instance of `YourModel` or `null`
$otherModel = Spatie\PrefixedIds\PrefixedIds::find('other_model_3Fjmmfsmls'); // returns an instance of `OtherModel` or `null`
```

## Using the prefixed ids in your routes

To use the prefixed ids in your routes, you'll have to add the `getRouteKeyName` method to your model. It should return the name of the attribute that holds the prefixed id.

```php
public function getRouteKeyName()
{
    return 'prefixed_id';
}
```

With this in place a route defined as...

```php
Route::get('/api/your-models/{yourModel}', YourModelController::class)`
```

... can be invoked with an URL like `/api/your-models/your_model_fekjlmsme39dmMS`.

You'll find more info on route model binding in [the Laravel docs](https://laravel.com/docs/master/routing#route-model-binding).

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

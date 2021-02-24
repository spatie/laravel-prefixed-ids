<?php

namespace Spatie\PrefixedIds;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PrefixedIdsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-prefixed-ids')
            ->hasConfigFile();
    }
}

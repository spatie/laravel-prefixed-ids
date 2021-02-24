<?php

namespace Spatie\PrefixedIds;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\PrefixedIds\Commands\PrefixedIdsCommand;

class PrefixedIdsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-prefixed-ids')
            ->hasConfigFile();
    }
}

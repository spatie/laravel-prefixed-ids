<?php

namespace Spatie\PrefixedIds;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\PrefixedIds\Commands\PrefixedIdsCommand;

class PrefixedIdsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-prefixed-ids')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_prefixed_ids_table')
            ->hasCommand(PrefixedIdsCommand::class);
    }
}

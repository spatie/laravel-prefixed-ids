<?php

namespace Spatie\PrefixedIds;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

use Spatie\PrefixedIds\Commands\StubsCommand;

class PrefixedIdsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-prefixed-ids')
            ->hasConfigFile();

        $this->registerCommands();
    }

    protected function registerCommands()
    {
        if (! $this->app->runningInConsole()) return;

        $this->commands([
            StubsCommand::class,        // prefixedids:stubs
        ]);
    }
}

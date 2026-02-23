<?php

namespace Spatie\PrefixedIds\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\PrefixedIds\PrefixedIds;
use Spatie\PrefixedIds\PrefixedIdsServiceProvider;
use Spatie\PrefixedIds\Tests\Database\Migrations\CreateOtherTestModelsTable;
use Spatie\PrefixedIds\Tests\Database\Migrations\CreateTestModelsTable;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        PrefixedIds::generateUniqueIdUsing(null);
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        (new CreateTestModelsTable())->up();
        (new CreateOtherTestModelsTable())->up();
    }

    protected function getPackageProviders($app)
    {
        return [
            PrefixedIdsServiceProvider::class,
        ];
    }
}

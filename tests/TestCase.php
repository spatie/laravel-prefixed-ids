<?php

namespace Spatie\PrefixedIds\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\PrefixedIds\PrefixedIds;
use Spatie\PrefixedIds\PrefixedIdsServiceProvider;
use Spatie\PrefixedIds\Tests\Database\Migrations\CreateOtherTestModelsTable;
use Spatie\PrefixedIds\Tests\Database\Migrations\CreateTestModelsTable;
use Spatie\Skeleton\SkeletonServiceProvider;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        ray()->newScreen($this->getName());
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

<?php

namespace Spatie\PrefixedIds\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

class StubsCommand extends Command
{
    protected $signature = 'prefixedids:stubs';

    protected $description = 'Publish Prefixed ID\'s stubs';

    public function handle()
    {
        if (! is_dir($stubsPath = base_path('stubs'))) {
            (new Filesystem)->makeDirectory($stubsPath);
        }

        file_put_contents(
            $stubsPath.'/model.stub',
            file_get_contents(__DIR__.'/model.stub')
        );

        file_put_contents(
            $stubsPath.'/migration.create.stub',
            file_get_contents(__DIR__.'/migration.create.stub')
        );

        $this->info('Stubs published successfully.');
    }
}

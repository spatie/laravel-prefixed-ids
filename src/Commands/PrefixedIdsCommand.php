<?php

namespace Spatie\PrefixedIds\Commands;

use Illuminate\Console\Command;

class PrefixedIdsCommand extends Command
{
    public $signature = 'laravel-prefixed-ids';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}

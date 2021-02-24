<?php

namespace Spatie\PrefixedIds;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Spatie\PrefixedIds\PrefixedIds
 */
class PrefixedIdsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-prefixed-ids';
    }
}

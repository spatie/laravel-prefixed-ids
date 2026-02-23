<?php

namespace Spatie\PrefixedIds\Exceptions;

use Exception;

class NoPrefixedModelFound extends Exception
{
    public static function make(string $prefixedId)
    {
        return new static("Could not find a prefixed model `{$prefixedId}`");
    }
}

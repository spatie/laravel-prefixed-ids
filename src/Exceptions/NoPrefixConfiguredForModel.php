<?php

namespace Spatie\PrefixedIds\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\Model;

class NoPrefixConfiguredForModel extends Exception
{
    public static function make(Model $model)
    {
        $modelClass = $model::class;

        return new static("Could not generate a prefixed id for model `{$modelClass}`");
    }
}

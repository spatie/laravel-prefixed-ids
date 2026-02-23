<?php

namespace Spatie\PrefixedIds\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Spatie\Ignition\Contracts\BaseSolution;
use Spatie\Ignition\Contracts\ProvidesSolution;
use Spatie\Ignition\Contracts\Solution;

class NoPrefixConfiguredForModel extends Exception implements ProvidesSolution
{
    public static function make(Model $model)
    {
        $modelClass = $model::class;

        return new static("Could not generate a prefixed id for model `{$modelClass}`");
    }

    public function getSolution(): Solution
    {
        return BaseSolution::create('Register the prefix of the model')
            ->setSolutionDescription("You should register your model using `Spatie\PrefixedIds\PrefixedIds::registerModel()` in a service provider")
            ->setDocumentationLinks([
                'Documentation' => 'https://github.com/spatie/laravel-prefixed-ids#registering-models-with-prefixed-ids',
            ]);
    }
}

<?php

namespace Spatie\PrefixedIds\Exceptions;

use Exception;
use Facade\IgnitionContracts\BaseSolution;
use Facade\IgnitionContracts\ProvidesSolution;
use Facade\IgnitionContracts\Solution;
use Illuminate\Database\Eloquent\Model;

class NoPrefixConfiguredForModel extends Exception implements ProvidesSolution
{
    public static function make(Model | string $model)
    {
        $modelClass = is_string($model) ? $model : $model::class;

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

<?php

namespace Spatie\PrefixedIds\Exceptions;

use Exception;
use Facade\IgnitionContracts\BaseSolution;
use Facade\IgnitionContracts\ProvidesSolution;
use Facade\IgnitionContracts\Solution;
use Illuminate\Database\Eloquent\Model;

class NoPrefixConfiguredForModel extends Exception implements ProvidesSolution
{
    public static function make(Model $model)
    {
        return new Exception("Could not generated a prefixed id for model `{$model::class}`");
    }

    public function getSolution(): Solution
    {
        return BaseSolution::create('Register the prefix of the model')
            ->setSolutionDescription("You should register the model `Spatie\PrefixedIds\PrefixedIds::registerModel() in a service provider")
            ->setDocumentationLinks([
                'Documentation' => 'https://github.com/spatie/laravel-prefixed-ids',
            ]);
    }
}

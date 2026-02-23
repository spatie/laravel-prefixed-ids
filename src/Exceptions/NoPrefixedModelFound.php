<?php

namespace Spatie\PrefixedIds\Exceptions;

use Exception;
use Spatie\Ignition\Contracts\BaseSolution;
use Spatie\Ignition\Contracts\ProvidesSolution;
use Spatie\Ignition\Contracts\Solution;

class NoPrefixedModelFound extends Exception implements ProvidesSolution
{
    public static function make(string $prefixedId)
    {
        return new static("Could not find a prefixed model `{$prefixedId}`");
    }

    public function getSolution(): Solution
    {
        return BaseSolution::create('Make sure the prefix of the model exists')
            ->setSolutionDescription("You should make sure your model has a valid `prefixed_id`")
            ->setDocumentationLinks([
                'Documentation' => 'https://github.com/spatie/laravel-prefixed-ids#usage',
            ]);
    }
}

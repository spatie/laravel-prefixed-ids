<?php

namespace Spatie\PrefixedIds;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PrefixedIds
{
    public static array $registeredModels = [];

    public function registerModels(array $registerModels)
    {
        foreach ($registerModels as $prefix => $model) {
            self::registerModel($prefix, $model);
        }
    }

    public static function registerModel(string $prefix, string $modelClass)
    {
        static::$registeredModels[$prefix] = $modelClass;
    }

    public static function clearRegisteredModels()
    {
        static::$registeredModels = [];
    }

    public static function getPrefixForModel(string $modelClass): ?string
    {
        $keyedByModelClass = array_flip(static::$registeredModels);

        return $keyedByModelClass[$modelClass] ?? null;
    }

    public static function getModel(string $prefixedId): ?Model
    {
        if (! $modelClass = static::getModelClass($prefixedId)) {
            return null;
        }

        return $modelClass::findByPrefixedId($prefixedId);
    }

    public static function getModelClass(string $prefixedId): ?string
    {
        if (! str_contains($prefixedId, config('prefixed-ids.glue'))) {
            return null;
        }

        $prefix = Str::before($prefixedId, config('prefixed-ids.glue'));

        return static::$registeredModels[$prefix] ?? null;
    }
}

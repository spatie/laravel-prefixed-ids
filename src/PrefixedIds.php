<?php

namespace Spatie\PrefixedIds;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Spatie\PrefixedIds\Exceptions\NoPrefixedModelFound;

class PrefixedIds
{
    public static array $registeredModels = [];

    public static ?Closure $generateUniqueIdUsing = null;

    public static function registerModels(array $registerModels): void
    {
        foreach ($registerModels as $prefix => $model) {
            self::registerModel($prefix, $model);
        }
    }

    public static function registerModel(string $prefix, string $modelClass): void
    {
        static::$registeredModels[$prefix] = $modelClass;
    }

    public static function clearRegisteredModels(): void
    {
        static::$registeredModels = [];
    }

    public static function getPrefixForModel(string $modelClass): ?string
    {
        $keyedByModelClass = array_flip(static::$registeredModels);

        return $keyedByModelClass[$modelClass] ?? null;
    }

    public static function find(string $prefixedId): ?Model
    {
        if (! $modelClass = static::getModelClass($prefixedId)) {
            return null;
        }

        return $modelClass::findByPrefixedId($prefixedId);
    }

    public static function findOrFail(string $prefixedId): ?Model
    {
        if (! $modelClass = static::getModelClass($prefixedId)) {
            throw NoPrefixedModelFound::make($prefixedId);
        }

        return $modelClass::findByPrefixedIdOrFail($prefixedId);
    }

    public static function getModelClass(string $prefixedId): ?string
    {
        foreach (static::$registeredModels as $prefix => $modelClass) {
            if (str_starts_with($prefixedId, $prefix)) {
                return $modelClass;
            }
        }

        return null;
    }

    public static function getUniqueId(): string
    {
        if(!static::$generateUniqueIdUsing){
            return str_replace('-', '', Str::uuid());
        }

        return (static::$generateUniqueIdUsing)();
    }

    public static function generateUniqueIdUsing(?Closure $generateUniqueIdUsing): void
    {
        static::$generateUniqueIdUsing = $generateUniqueIdUsing;
    }
}

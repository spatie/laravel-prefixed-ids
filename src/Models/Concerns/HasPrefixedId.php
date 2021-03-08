<?php

namespace Spatie\PrefixedIds\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\PrefixedIds\Exceptions\NoPrefixConfiguredForModel;
use Spatie\PrefixedIds\PrefixedIds;

trait HasPrefixedId
{
    public static function bootHasPrefixedId()
    {
        static::creating(function (Model $model) {
            $attributeName = config('prefixed-ids.prefixed_id_attribute_name');

            $model->{$attributeName} = $model->generatePrefixedId();
        });
    }

    public function getIncrementing()
    {
        return config('prefixed-ids.prefixed_id_is_primary');
    }

    public function getPrefixedIdAttribute(): ?string
    {
        $attributeName = config('prefixed-ids.prefixed_id_attribute_name');

        return $this->attributes[$attributeName] ?? null;
    }

    public static function findByPrefixedId(string $prefixedId): ?Model
    {
        $attributeName = config('prefixed-ids.prefixed_id_attribute_name');

        return static::firstWhere($attributeName, $prefixedId);
    }

    protected function getIdPrefix(): string
    {
        $prefix = PrefixedIds::getPrefixForModel(static::class);

        if (! $prefix) {
            throw NoPrefixConfiguredForModel::make($this);
        }

        return $prefix;
    }

    protected function generatePrefixedId(): string
    {
        return "{$this->getIdPrefix()}{$this->getUniquePartForPrefixId()}";
    }

    protected function getUniquePartForPrefixId(): string
    {
        if (config('prefixed-ids.should_use_ordered_uuid')) {
            return str_replace('-', '', Str::orderedUuid());
        }
        return str_replace('-', '', Str::uuid());
    }
}

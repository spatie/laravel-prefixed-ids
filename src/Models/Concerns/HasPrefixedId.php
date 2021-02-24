<?php

namespace Spatie\PrefixedIds\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\PrefixedIds\Exceptions\NoPrefixConfiguredForModel;
use Spatie\PrefixedIds\PrefixedIds;

trait HasPrefixedId
{
    public function HasPrefixedIdBooted()
    {
        static::creating(function (Model  $model) {
            $model->prefixed_id = $this->generatePrefixedId();
        });
    }

    public function findByPrefixedId(string $prefixedId): ?Model {
        return static::firstWhere('prefixed_id', $prefixedId);
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
        $glue = config('prefixed-ids.glue');

        return "{$this->getIdPrefix()}{$glue}}{$this->getIdPrefix()}";
    }

    protected function getUniquePartForPrefixId(): string
    {
        return str_replace('-', '', Str::uuid());
    }
}

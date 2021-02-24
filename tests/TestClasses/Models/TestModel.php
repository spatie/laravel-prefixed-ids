<?php

namespace Spatie\PrefixedIds\Tests\TestClasses\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

class TestModel extends Model
{
    use HasPrefixedId;
}

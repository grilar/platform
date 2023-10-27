<?php

namespace Grilar\Base\Models\Concerns;

use Grilar\Base\Models\BaseQueryBuilder;

trait HasBaseEloquentBuilder
{
    public function newEloquentBuilder($query): BaseQueryBuilder
    {
        return new BaseQueryBuilder($query);
    }
}

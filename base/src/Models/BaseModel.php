<?php

namespace Grilar\Base\Models;

use Grilar\Base\Contracts\BaseModel as BaseModelContract;
use Grilar\Base\Facades\MacroableModels;
use Grilar\Base\Models\Concerns\HasBaseEloquentBuilder;
use Grilar\Base\Models\Concerns\HasMetadata;
use Grilar\Base\Models\Concerns\HasUuidsOrIntegerIds;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @method static \Grilar\Base\Models\BaseQueryBuilder<static> query()
 */
class BaseModel extends Model implements BaseModelContract
{
    use HasBaseEloquentBuilder;
    use HasMetadata;
    use HasUuidsOrIntegerIds;

    public function __get($key)
    {
        if (MacroableModels::modelHasMacro($this::class, $method = 'get' . Str::studly($key) . 'Attribute')) {
            return call_user_func([$this, $method]);
        }

        return parent::__get($key);
    }
}

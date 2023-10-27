<?php

namespace Grilar\Base\Events;

use Illuminate\Foundation\Events\Dispatchable;

class SystemUpdateDBMigrated
{
    use Dispatchable;

    public function __construct()
    {
    }
}

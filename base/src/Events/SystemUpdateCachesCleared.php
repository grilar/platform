<?php

namespace Grilar\Base\Events;

use Illuminate\Foundation\Events\Dispatchable;

class SystemUpdateCachesCleared
{
    use Dispatchable;

    public function __construct()
    {
    }
}

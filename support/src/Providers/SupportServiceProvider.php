<?php

namespace Grilar\Support\Providers;

use Grilar\Base\Supports\ServiceProvider;

class SupportServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app['files']->requireOnce(core_path('support/helpers/common.php'));
    }
}

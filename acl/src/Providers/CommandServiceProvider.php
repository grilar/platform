<?php

namespace Grilar\ACL\Providers;

use Grilar\ACL\Commands\UserCreateCommand;
use Grilar\Base\Supports\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                UserCreateCommand::class,
            ]);
        }
    }
}

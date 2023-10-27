<?php

namespace Grilar\ACL\Providers;

use Grilar\ACL\Hooks\UserWidgetHook;
use Grilar\Base\Supports\ServiceProvider;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        add_filter(DASHBOARD_FILTER_ADMIN_LIST, [UserWidgetHook::class, 'addUserStatsWidget'], 12, 2);
    }
}

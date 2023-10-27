<?php

namespace Grilar\Base\Providers;

use Grilar\Base\Commands\ActivateLicenseCommand;
use Grilar\Base\Commands\CleanupSystemCommand;
use Grilar\Base\Commands\ClearExpiredCacheCommand;
use Grilar\Base\Commands\ClearLogCommand;
use Grilar\Base\Commands\ExportDatabaseCommand;
use Grilar\Base\Commands\FetchGoogleFontsCommand;
use Grilar\Base\Commands\InstallCommand;
use Grilar\Base\Commands\PublishAssetsCommand;
use Grilar\Base\Commands\UpdateCommand;
use Grilar\Base\Supports\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class CommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->commands([
            ActivateLicenseCommand::class,
            CleanupSystemCommand::class,
            ClearExpiredCacheCommand::class,
            ClearLogCommand::class,
            ExportDatabaseCommand::class,
            FetchGoogleFontsCommand::class,
            InstallCommand::class,
            PublishAssetsCommand::class,
            UpdateCommand::class,
        ]);

        $this->app->afterResolving(Schedule::class, function (Schedule $schedule) {
            $schedule->command(ClearExpiredCacheCommand::class)->everyFiveMinutes();
        });
    }
}

<?php

namespace Grilar\Setting\Providers;

use Grilar\Base\Facades\DashboardMenu;
use Grilar\Base\Facades\EmailHandler;
use Grilar\Base\Supports\ServiceProvider;
use Grilar\Base\Traits\LoadAndPublishDataTrait;
use Grilar\Setting\Commands\CronJobTestCommand;
use Grilar\Setting\Facades\Setting;
use Grilar\Setting\Models\Setting as SettingModel;
use Grilar\Setting\Repositories\Eloquent\SettingRepository;
use Grilar\Setting\Repositories\Interfaces\SettingInterface;
use Grilar\Setting\Supports\DatabaseSettingStore;
use Grilar\Setting\Supports\SettingStore;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Events\RouteMatched;

class SettingServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    protected bool $defer = true;

    public function register(): void
    {
        $this->setNamespace('core/setting')
            ->loadAndPublishConfigurations(['general']);

        $this->app->singleton(SettingStore::class, function () {
            return new DatabaseSettingStore();
        });

        $this->app->bind(SettingInterface::class, function () {
            return new SettingRepository(new SettingModel());
        });

        if (! class_exists('Setting')) {
            AliasLoader::getInstance()->alias('Setting', Setting::class);
        }

        $this->loadHelpers();
    }

    public function boot(): void
    {
        $this
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadAnonymousComponents()
            ->loadAndPublishTranslations()
            ->loadAndPublishConfigurations(['permissions', 'email'])
            ->loadMigrations()
            ->publishAssets();

        $this->app['events']->listen(RouteMatched::class, function () {
            DashboardMenu::make()
                ->registerItem([
                    'id' => 'cms-core-settings',
                    'priority' => 998,
                    'parent_id' => null,
                    'name' => 'core/setting::setting.title',
                    'icon' => 'fa fa-cogs',
                    'url' => route('settings.options'),
                    'permissions' => ['settings.options'],
                ])
                ->registerItem([
                    'id' => 'cms-core-settings-general',
                    'priority' => 1,
                    'parent_id' => 'cms-core-settings',
                    'name' => 'core/base::layouts.setting_general',
                    'icon' => null,
                    'url' => route('settings.options'),
                    'permissions' => ['settings.options'],
                ])
                ->registerItem([
                    'id' => 'cms-core-settings-email',
                    'priority' => 2,
                    'parent_id' => 'cms-core-settings',
                    'name' => 'core/base::layouts.setting_email',
                    'icon' => null,
                    'url' => route('settings.email'),
                    'permissions' => ['settings.email'],
                ])
                ->registerItem([
                    'id' => 'cms-core-settings-media',
                    'priority' => 3,
                    'parent_id' => 'cms-core-settings',
                    'name' => 'core/setting::setting.media.title',
                    'icon' => null,
                    'url' => route('settings.media'),
                    'permissions' => ['settings.media'],
                ])
                ->registerItem([
                    'id' => 'cms-core-settings-cronjob',
                    'priority' => 999,
                    'parent_id' => 'cms-core-settings',
                    'name' => 'core/setting::setting.cronjob.name',
                    'url' => route('settings.cronjob'),
                    'permissions' => ['settings.cronjob'],
                ]);

            EmailHandler::addTemplateSettings('base', config('core.setting.email', []), 'core');
        });

        $this->commands([
            CronJobTestCommand::class,
        ]);

        $this->app->afterResolving(Schedule::class, function (Schedule $schedule) {
            rescue(function () use ($schedule) {
                $schedule
                    ->command(CronJobTestCommand::class)
                    ->everyMinute();
            });
        });
    }

    public function provides(): array
    {
        return [
            SettingStore::class,
        ];
    }
}

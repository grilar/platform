<?php

namespace Grilar\Dashboard\Providers;

use Grilar\Base\Facades\DashboardMenu;
use Grilar\Base\Supports\ServiceProvider;
use Grilar\Base\Traits\LoadAndPublishDataTrait;
use Grilar\Dashboard\Models\DashboardWidget;
use Grilar\Dashboard\Models\DashboardWidgetSetting;
use Grilar\Dashboard\Repositories\Eloquent\DashboardWidgetRepository;
use Grilar\Dashboard\Repositories\Eloquent\DashboardWidgetSettingRepository;
use Grilar\Dashboard\Repositories\Interfaces\DashboardWidgetInterface;
use Grilar\Dashboard\Repositories\Interfaces\DashboardWidgetSettingInterface;
use Illuminate\Routing\Events\RouteMatched;

/**
 * @since 02/07/2016 09:50 AM
 */
class DashboardServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->bind(DashboardWidgetInterface::class, function () {
            return new DashboardWidgetRepository(new DashboardWidget());
        });

        $this->app->bind(DashboardWidgetSettingInterface::class, function () {
            return new DashboardWidgetSettingRepository(new DashboardWidgetSetting());
        });
    }

    public function boot(): void
    {
        $this->setNamespace('core/dashboard')
            ->loadHelpers()
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->publishAssets()
            ->loadMigrations();

        $this->app['events']->listen(RouteMatched::class, function () {
            DashboardMenu::registerItem([
                'id' => 'cms-core-dashboard',
                'priority' => 0,
                'parent_id' => null,
                'name' => 'core/base::layouts.dashboard',
                'icon' => 'fa fa-home',
                'url' => route('dashboard.index'),
                'permissions' => [],
            ]);
        });
    }
}

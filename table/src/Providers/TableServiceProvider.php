<?php

namespace Grilar\Table\Providers;

use Grilar\Base\Supports\ServiceProvider;
use Grilar\Base\Traits\LoadAndPublishDataTrait;
use Grilar\Table\ApiResourceDataTable;
use Grilar\Table\CollectionDataTable;
use Grilar\Table\EloquentDataTable;
use Grilar\Table\QueryDataTable;

class TableServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app['config']->set([
            'datatables.engines' => [
                'eloquent' => EloquentDataTable::class,
                'query' => QueryDataTable::class,
                'collection' => CollectionDataTable::class,
                'resource' => ApiResourceDataTable::class,
            ],
        ]);
    }

    public function boot(): void
    {
        $this->setNamespace('core/table')
            ->loadHelpers()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadRoutes()
            ->publishAssets();
    }
}

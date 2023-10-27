<?php

namespace Grilar\Chart\Providers;

use Grilar\Base\Supports\ServiceProvider;
use Grilar\Base\Traits\LoadAndPublishDataTrait;

class ChartServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this->setNamespace('core/chart')
            ->loadAndPublishViews();
    }
}

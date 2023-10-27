<?php

namespace Grilar\Base\Providers;

use Grilar\Base\Events\AdminNotificationEvent;
use Grilar\Base\Events\BeforeEditContentEvent;
use Grilar\Base\Events\CreatedContentEvent;
use Grilar\Base\Events\DeletedContentEvent;
use Grilar\Base\Events\SendMailEvent;
use Grilar\Base\Events\UpdatedContentEvent;
use Grilar\Base\Listeners\AdminNotificationListener;
use Grilar\Base\Listeners\BeforeEditContentListener;
use Grilar\Base\Listeners\CreatedContentListener;
use Grilar\Base\Listeners\DeletedContentListener;
use Grilar\Base\Listeners\SendMailListener;
use Grilar\Base\Listeners\UpdatedContentListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        SendMailEvent::class => [
            SendMailListener::class,
        ],
        CreatedContentEvent::class => [
            CreatedContentListener::class,
        ],
        UpdatedContentEvent::class => [
            UpdatedContentListener::class,
        ],
        DeletedContentEvent::class => [
            DeletedContentListener::class,
        ],
        BeforeEditContentEvent::class => [
            BeforeEditContentListener::class,
        ],
        AdminNotificationEvent::class => [
            AdminNotificationListener::class,
        ],
    ];

    public function boot(): void
    {
        $this->app['events']->listen(['cache:cleared'], function () {
            $this->app['files']->delete(storage_path('cache_keys.json'));
        });
    }
}

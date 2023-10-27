<?php

namespace Grilar\ACL\Providers;

use Grilar\ACL\Events\RoleAssignmentEvent;
use Grilar\ACL\Events\RoleUpdateEvent;
use Grilar\ACL\Listeners\LoginListener;
use Grilar\ACL\Listeners\RoleAssignmentListener;
use Grilar\ACL\Listeners\RoleUpdateListener;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        RoleUpdateEvent::class => [
            RoleUpdateListener::class,
        ],
        RoleAssignmentEvent::class => [
            RoleAssignmentListener::class,
        ],
        Login::class => [
            LoginListener::class,
        ],
    ];
}

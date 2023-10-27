<?php

namespace Grilar\ACL\Listeners;

use Grilar\ACL\Models\User;
use Illuminate\Auth\Events\Login;

class LoginListener
{
    public function handle(Login $event): void
    {
        if (! $event->user instanceof User) {
            return;
        }

        cache()->forget(md5('cache-dashboard-menu-' . $event->user->getKey()));
    }
}

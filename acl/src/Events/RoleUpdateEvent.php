<?php

namespace Grilar\ACL\Events;

use Grilar\ACL\Models\Role;
use Grilar\Base\Events\Event;
use Illuminate\Queue\SerializesModels;

class RoleUpdateEvent extends Event
{
    use SerializesModels;

    public function __construct(public Role $role)
    {
    }
}

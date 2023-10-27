<?php

namespace Grilar\ACL\Events;

use Grilar\ACL\Models\Role;
use Grilar\ACL\Models\User;
use Grilar\Base\Events\Event;
use Illuminate\Queue\SerializesModels;

class RoleAssignmentEvent extends Event
{
    use SerializesModels;

    public function __construct(public Role $role, public User $user)
    {
    }
}

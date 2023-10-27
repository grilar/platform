<?php

namespace Grilar\ACL\Repositories\Interfaces;

use Grilar\Support\Repositories\Interfaces\RepositoryInterface;

interface UserInterface extends RepositoryInterface
{
    public function getUniqueUsernameFromEmail(string $email): string;
}

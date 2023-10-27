<?php

namespace Grilar\ACL\Repositories\Interfaces;

use Grilar\Support\Repositories\Interfaces\RepositoryInterface;

interface RoleInterface extends RepositoryInterface
{
    public function createSlug(string $name, int|string $id): string;
}

<?php

namespace Grilar\Base\Facades;

use Grilar\Base\Supports\DashboardMenu as DashboardMenuSupport;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Grilar\Base\Supports\DashboardMenu make()
 * @method static \Grilar\Base\Supports\DashboardMenu registerItem(array $options)
 * @method static \Grilar\Base\Supports\DashboardMenu removeItem(array|string $id, $parentId = null)
 * @method static bool hasItem(string $id, string|null $parentId = null)
 * @method static \Illuminate\Support\Collection getAll()
 *
 * @see \Grilar\Base\Supports\DashboardMenu
 */
class DashboardMenu extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return DashboardMenuSupport::class;
    }
}

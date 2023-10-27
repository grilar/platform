<?php

namespace Grilar\Dashboard\Repositories\Interfaces;

use Grilar\Support\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface DashboardWidgetSettingInterface extends RepositoryInterface
{
    public function getListWidget(): Collection;
}

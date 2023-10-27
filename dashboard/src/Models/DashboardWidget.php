<?php

namespace Grilar\Dashboard\Models;

use Grilar\Base\Casts\SafeContent;
use Grilar\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DashboardWidget extends BaseModel
{
    protected $table = 'dashboard_widgets';

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'name' => SafeContent::class,
    ];

    public function settings(): HasMany
    {
        return $this->hasMany(DashboardWidgetSetting::class, 'widget_id', 'id');
    }

    protected static function booted(): void
    {
        static::deleted(function (DashboardWidget $widget) {
            $widget->settings()->delete();
        });
    }
}

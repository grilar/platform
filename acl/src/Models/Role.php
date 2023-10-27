<?php

namespace Grilar\ACL\Models;

use Grilar\ACL\Traits\PermissionTrait;
use Grilar\Base\Casts\SafeContent;
use Grilar\Base\Facades\BaseHelper;
use Grilar\Base\Models\BaseModel;
use Grilar\Base\Models\Concerns\HasSlug;
use Grilar\Base\Supports\Helper;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends BaseModel
{
    use HasSlug;
    use PermissionTrait;

    protected $table = 'roles';

    protected $fillable = [
        'name',
        'slug',
        'permissions',
        'description',
        'is_default',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'permissions' => 'json',
        'name' => SafeContent::class,
        'description' => SafeContent::class,
    ];

    public function delete(): bool|null
    {
        if ($this->exists) {
            $this->users()->detach();
        }

        return parent::delete();
    }

    public function users(): BelongsToMany
    {
        return $this
            ->belongsToMany(User::class, 'role_users', 'role_id', 'user_id')
            ->withTimestamps();
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function getAvailablePermissions(): array
    {
        $permissions = [];

        $types = ['core', 'packages', 'plugins'];

        foreach ($types as $type) {
            foreach (BaseHelper::scanFolder(platform_path($type)) as $module) {
                $configuration = config(strtolower($type . '.' . $module . '.permissions'));
                if (! empty($configuration)) {
                    foreach ($configuration as $config) {
                        $permissions[$config['flag']] = $config;
                    }
                }
            }
        }

        return $permissions;
    }

    protected static function booted(): void
    {
        self::saving(function (self $model) {
            $model->slug = self::createSlug($model->slug ?: $model->name, $model->getKey());
        });

        self::deleted(function (self $model) {
            $model->users()->detach();

            Helper::clearCache();
        });
    }
}

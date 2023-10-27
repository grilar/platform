<?php

namespace Grilar\ACL\Tables;

use Grilar\ACL\Models\Role;
use Grilar\Base\Facades\BaseHelper;
use Grilar\Table\Abstracts\TableAbstract;
use Grilar\Table\Actions\DeleteAction;
use Grilar\Table\Actions\EditAction;
use Grilar\Table\BulkActions\DeleteBulkAction;
use Grilar\Table\Columns\Column;
use Grilar\Table\Columns\CreatedAtColumn;
use Grilar\Table\Columns\IdColumn;
use Grilar\Table\Columns\NameColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;

class RoleTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Role::class)
            ->addActions([
                EditAction::make()->route('roles.edit'),
                DeleteAction::make()->route('roles.destroy'),
            ]);
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('created_by', function (Role $item) {
                return BaseHelper::clean($item->author->name);
            });

        return $this->toJson($data);
    }

    public function query(): Relation|Builder|QueryBuilder
    {
        $query = $this
            ->getModel()
            ->query()
            ->with('author')
            ->select([
                'id',
                'name',
                'description',
                'created_at',
                'created_by',
            ]);

        return $this->applyScopes($query);
    }

    public function columns(): array
    {
        return [
            IdColumn::make(),
            NameColumn::make()->route('roles.edit'),
            Column::make('description')
                ->title(trans('core/base::tables.description'))
                ->alignLeft(),
            CreatedAtColumn::make(),
            Column::make('created_by')
                ->title(trans('core/acl::permissions.created_by'))
                ->width(100),
        ];
    }

    public function buttons(): array
    {
        return $this->addCreateButton(route('roles.create'), 'roles.create');
    }

    public function bulkActions(): array
    {
        return [
            DeleteBulkAction::make()->permission('roles.destroy'),
        ];
    }

    public function getBulkChanges(): array
    {
        return [
            'name' => [
                'title' => trans('core/base::tables.name'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
        ];
    }
}

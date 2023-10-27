<?php

namespace Grilar\Table\Abstracts\Concerns;

use Grilar\Base\Models\BaseModel;
use Grilar\Table\Abstracts\TableActionAbstract;
use Grilar\Table\Columns\RowActionsColumn;
use Closure;
use Illuminate\Database\Eloquent\Model;
use LogicException;

trait HasActions
{
    /**
     * @var \Grilar\Table\Abstracts\TableActionAbstract[] $actions
     */
    protected array $rowActions = [];

    protected array $rowActionsEditCallbacks = [];

    /**
     * @deprecated since v6.8.0
     */
    protected $hasOperations = true;

    /**
     * @internal
     */
    public function getRowActions(): array
    {
        return collect($this->rowActions)
            ->filter(fn (TableActionAbstract $action) => $action->currentUserHasAnyPermissions())
            ->mapWithKeys(fn (TableActionAbstract $action, string $name) => [$name => $this->getAction($name)])
            ->sortBy(fn (TableActionAbstract $action) => $action->getPriority())
            ->all();
    }

    public function addAction(TableActionAbstract $action): static
    {
        $this->rowActions[$action->getName()] = $action;

        return $this;
    }

    /**
     * @param \Grilar\Table\Abstracts\TableActionAbstract[] $actions
     */
    public function addActions(array $actions): static
    {
        $newActions = [];

        foreach ($actions as $action) {
            $newActions[$action->getName()] = $action;
        }

        $this->rowActions = array_merge($this->rowActions, $newActions);

        return $this;
    }

    public function removeAction(string $name): static
    {
        unset($this->rowActions[$name]);

        return $this;
    }

    public function removeActions(array $name): static
    {
        foreach ($name as $key) {
            $this->removeAction($key);
        }

        return $this;
    }

    public function removeAllActions(): static
    {
        $this->rowActions = [];

        return $this;
    }

    public function hasAction(string $name): bool
    {
        return isset($this->rowActions[$name]);
    }

    public function hasActions(): bool
    {
        return ! empty($this->getRowActions()) || $this->hasOperations;
    }

    /**
     * @param \Closure(\Grilar\Table\Abstracts\TableActionAbstract $action): \Grilar\Table\Abstracts\TableActionAbstract $callback
     */
    public function editAction(string $name, Closure $callback): static
    {
        if (! $this->hasAction($name)) {
            throw new LogicException('Action not found.');
        }

        $this->rowActionsEditCallbacks[$name][] = $callback;

        return $this;
    }

    public function getAction(string $name): TableActionAbstract
    {
        if (! $this->hasAction($name)) {
            throw new LogicException('Action not found.');
        }

        $action = $this->rowActions[$name];

        if (isset($this->rowActionsEditCallbacks[$name])) {
            foreach ($this->rowActionsEditCallbacks as $callback) {
                $callback($action);
            }
        }

        return $action;
    }

    protected function getRowActionsHeading(): array
    {
        return [
            RowActionsColumn::make()->width(70 * count($this->getRowActions())),
        ];
    }

    public function renderActionsCell($model): string
    {
        if (! $model instanceof BaseModel) {
            return '';
        }

        return view('core/table::row-actions', [
            'model' => $model,
            'actions' => $this->getRowActions(),
        ])->render();
    }

    /**
     * @deprecated since v6.8.0
     */
    public function getOperationsHeading()
    {
        return [
            RowActionsColumn::make('operations')
                ->title(trans('core/base::tables.operations'))
                ->width(134),
        ];
    }

    /**
     * @deprecated since v6.8.0
     */
    protected function getOperations(string|null $edit, string|null $delete, Model $item, string|null $extra = null): string
    {
        return apply_filters(
            'table_operation_buttons',
            view('core/table::partials.actions', compact('edit', 'delete', 'item', 'extra'))->render(),
            $item,
            $edit,
            $delete,
            $extra
        );
    }
}

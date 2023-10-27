<?php

namespace Grilar\Table\Actions;

use Grilar\Table\Abstracts\TableActionAbstract;
use Grilar\Table\Actions\Concerns\HasAction;
use Grilar\Table\Actions\Concerns\HasAttributes;
use Grilar\Table\Actions\Concerns\HasColor;
use Grilar\Table\Actions\Concerns\HasIcon;
use Grilar\Table\Actions\Concerns\HasUrl;

class Action extends TableActionAbstract
{
    use HasAction;
    use HasAttributes;
    use HasColor;
    use HasIcon;
    use HasUrl;

    public function render(): string
    {
        return view('core/table::actions.action', [
            'action' => $this,
        ])->render();
    }
}

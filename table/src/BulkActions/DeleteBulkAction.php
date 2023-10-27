<?php

namespace Grilar\Table\BulkActions;

use Grilar\Base\Events\DeletedContentEvent;
use Grilar\Base\Exceptions\DisabledInDemoModeException;
use Grilar\Base\Facades\BaseHelper;
use Grilar\Base\Http\Responses\BaseHttpResponse;
use Grilar\Base\Models\BaseModel;
use Grilar\Table\Abstracts\TableBulkActionAbstract;

class DeleteBulkAction extends TableBulkActionAbstract
{
    public function __construct()
    {
        $this
            ->label(trans('core/table::table.delete'))
            ->confirmationModalButton(trans('core/table::table.delete'))
            ->beforeDispatch(function () {
                if (BaseHelper::hasDemoModeEnabled()) {
                    throw new DisabledInDemoModeException();
                }
            });
    }

    public function dispatch(BaseModel $model, array $ids): BaseHttpResponse
    {
        $model->newQuery()->whereIn('id', $ids)->each(function (BaseModel $item) {
            $item->delete();

            event(new DeletedContentEvent('', request(), $item));
        });

        return (new BaseHttpResponse())
            ->setMessage(trans('core/base::notices.delete_success_message'));
    }
}

<?php

namespace Grilar\Base\Traits;

use Grilar\Base\Events\DeletedContentEvent;
use Grilar\Base\Http\Responses\BaseHttpResponse;
use Grilar\Base\Models\BaseModel;
use Grilar\Support\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Http\Request;

/**
 * @deprecated since v6.8.0
 */
trait HasDeleteManyItemsTrait
{
    protected function executeDeleteItems(
        Request $request,
        BaseHttpResponse $response,
        RepositoryInterface|BaseModel $repository,
        string $screen
    ): BaseHttpResponse {
        $ids = $request->input('ids');

        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $item = $repository->findOrFail($id);
            if (! $item) {
                continue;
            }

            $item->delete();

            event(new DeletedContentEvent($screen, $request, $item));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}

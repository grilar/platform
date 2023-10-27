<?php

namespace Grilar\Base\Events;

use Grilar\Base\Contracts\BaseModel;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class UpdatedContentEvent extends Event
{
    use SerializesModels;

    public string $screen;

    public function __construct(string|BaseModel $screen, public Request $request, public bool|BaseModel|null $data)
    {
        if ($screen instanceof BaseModel) {
            $screen = $screen->getTable();
        }

        $this->screen = $screen;
    }
}

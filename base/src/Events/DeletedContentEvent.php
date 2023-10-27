<?php

namespace Grilar\Base\Events;

use Grilar\Base\Contracts\BaseModel;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class DeletedContentEvent extends Event
{
    use SerializesModels;

    public function __construct(public string $screen, public Request $request, public bool|BaseModel|null $data)
    {
    }
}

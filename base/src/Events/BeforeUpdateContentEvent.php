<?php

namespace Grilar\Base\Events;

use Grilar\Base\Contracts\BaseModel;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class BeforeUpdateContentEvent extends Event
{
    use SerializesModels;

    public function __construct(public Request $request, public bool|BaseModel|null $data)
    {
    }
}

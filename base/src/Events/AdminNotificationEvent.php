<?php

namespace Grilar\Base\Events;

use Grilar\Base\Supports\AdminNotificationItem;
use Illuminate\Queue\SerializesModels;

class AdminNotificationEvent extends Event
{
    use SerializesModels;

    public function __construct(public AdminNotificationItem $item)
    {
    }
}

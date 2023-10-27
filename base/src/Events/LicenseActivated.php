<?php

namespace Grilar\Base\Events;

use Illuminate\Foundation\Events\Dispatchable;

class LicenseActivated
{
    use Dispatchable;

    public function __construct(
        public string $licenseKey,
        public string $licenseName,
    ) {
    }
}

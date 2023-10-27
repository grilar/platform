<?php

namespace Grilar\Base\Forms\Fields;

use Grilar\Base\Facades\Assets;
use Grilar\Base\Forms\FormField;

class TimeField extends FormField
{
    protected function getTemplate(): string
    {
        Assets::addScripts(['timepicker'])
            ->addStyles(['timepicker']);

        return 'core/base::forms.fields.time';
    }
}

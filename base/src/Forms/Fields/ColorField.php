<?php

namespace Grilar\Base\Forms\Fields;

use Grilar\Base\Facades\Assets;
use Grilar\Base\Forms\FormField;

class ColorField extends FormField
{
    protected function getTemplate(): string
    {
        Assets::addScripts(['colorpicker'])
            ->addStyles(['colorpicker']);

        return 'core/base::forms.fields.color';
    }
}

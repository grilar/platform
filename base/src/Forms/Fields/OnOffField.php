<?php

namespace Grilar\Base\Forms\Fields;

use Grilar\Base\Forms\FormField;

class OnOffField extends FormField
{
    protected function getTemplate(): string
    {
        return 'core/base::forms.fields.on-off';
    }
}

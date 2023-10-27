<?php

namespace Grilar\Base\Forms\Fields;

use Grilar\Base\Forms\FormField;

class MultiCheckListField extends FormField
{
    protected function getTemplate(): string
    {
        return 'core/base::forms.fields.multi-check-list';
    }
}

<?php

namespace Grilar\Base\Forms\Fields;

use Grilar\Base\Forms\FormField;

class MediaFileField extends FormField
{
    protected function getTemplate(): string
    {
        return 'core/base::forms.fields.media-file';
    }
}

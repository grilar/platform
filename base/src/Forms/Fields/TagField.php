<?php

namespace Grilar\Base\Forms\Fields;

use Grilar\Base\Facades\Assets;
use Grilar\Base\Forms\FormField;

class TagField extends FormField
{
    protected function getTemplate(): string
    {
        Assets::addStylesDirectly('vendor/core/core/base/libraries/tagify/tagify.css')
            ->addScriptsDirectly([
                'vendor/core/core/base/libraries/tagify/tagify.js',
                'vendor/core/core/base/js/tags.js',
            ]);

        return 'core/base::forms.fields.tags';
    }
}

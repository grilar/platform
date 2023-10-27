<?php

namespace Grilar\Base\Forms\Fields;

use Grilar\Base\Facades\Assets;
use Grilar\Base\Forms\FormField;

class MediaImagesField extends FormField
{
    protected function getTemplate(): string
    {
        Assets::addScripts(['jquery-ui']);

        return 'core/base::forms.fields.media-images';
    }
}

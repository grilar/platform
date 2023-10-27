<?php

namespace Grilar\ACL\Http\Requests;

use Grilar\Media\Facades\RvMedia;
use Grilar\Support\Http\Requests\Request;

class AvatarRequest extends Request
{
    public function rules(): array
    {
        return [
            'avatar_file' => RvMedia::imageValidationRule(),
            'avatar_data' => 'required|string',
        ];
    }
}

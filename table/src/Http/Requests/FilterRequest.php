<?php

namespace Grilar\Table\Http\Requests;

use Grilar\Support\Http\Requests\Request;

class FilterRequest extends Request
{
    public function rules(): array
    {
        return [
            'class' => 'required|string',
        ];
    }
}

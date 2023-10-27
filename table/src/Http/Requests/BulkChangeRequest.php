<?php

namespace Grilar\Table\Http\Requests;

use Grilar\Support\Http\Requests\Request;

class BulkChangeRequest extends Request
{
    public function rules(): array
    {
        return [
            'class' => 'required|string',
            'key' => 'nullable|string',
        ];
    }
}

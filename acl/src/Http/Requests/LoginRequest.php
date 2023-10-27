<?php

namespace Grilar\ACL\Http\Requests;

use Grilar\Support\Http\Requests\Request;

class LoginRequest extends Request
{
    public function rules(): array
    {
        return [
            'username' => 'required|min:4|max:30',
            'password' => 'required|string|min:6|max:60',
        ];
    }
}

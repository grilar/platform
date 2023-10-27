<?php

namespace Grilar\ACL\Http\Requests;

use Grilar\Support\Http\Requests\Request;

class ResetPasswordRequest extends Request
{
    public function rules(): array
    {
        return [
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ];
    }
}

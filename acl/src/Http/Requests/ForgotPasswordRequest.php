<?php

namespace Grilar\ACL\Http\Requests;

use Grilar\Support\Http\Requests\Request;

class ForgotPasswordRequest extends Request
{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
        ];
    }
}

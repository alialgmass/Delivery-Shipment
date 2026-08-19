<?php

namespace Modules\Auth\Http\Requests;

use App\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email:filter|string',
            'password' => 'required|string',
        ];
    }
}

<?php

namespace Modules\Auth\Http\Requests;

use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email:filter|string|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ];
    }
}

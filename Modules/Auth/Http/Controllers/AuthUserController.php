<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use Modules\User\Http\Resources\UserResource;

class AuthUserController extends ApiController
{
    public function __invoke()
    {
        return $this->apiBody([
            'user' => UserResource::make(auth()->user()),
        ])->apiResponse();
    }
}

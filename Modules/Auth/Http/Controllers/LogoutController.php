<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use Modules\Auth\Services\AuthService;

class LogoutController extends ApiController
{
    public function __invoke(AuthService $authService)
    {
        $authService->logout(auth()->user());

        return $this->apiMessage('Logged out successfully.')->apiResponse();
    }
}

<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Services\AuthService;
use Modules\User\Http\Resources\UserResource;

class LoginController extends ApiController
{
    public function __invoke(LoginRequest $request, AuthService $authService)
    {
        $user = $authService->login($request->validated());

        return $this->apiMessage('Login successful.')
            ->apiBody([
                'accessToken' => $authService->generateToken($user),
                'user' => UserResource::make($user),
            ])->apiResponse();
    }
}

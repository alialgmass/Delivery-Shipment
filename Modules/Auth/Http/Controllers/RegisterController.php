<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Auth\Services\AuthService;
use Modules\User\Http\Resources\UserResource;

class RegisterController extends ApiController
{
    public function __invoke(RegisterRequest $request, AuthService $authService)
    {
        $user = $authService->register($request->validated());

        return $this->apiMessage('Registration successful.')
            ->apiBody([
                'accessToken' => $authService->generateToken($user),
                'user' => UserResource::make($user),
            ])->apiResponse();
    }
}

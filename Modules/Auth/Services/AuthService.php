<?php

namespace Modules\Auth\Services;

use App\Exceptions\ApiException\ExceptionResponse;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class AuthService
{
    /**
     * @throws ExceptionResponse
     */
    public function login(array $credentials): Authenticatable
    {
        if (! auth()->attempt($credentials)) {
            throw ExceptionResponse::instance('Invalid credentials.', 401)->setCustomCode(4001);
        }

        return auth()->user();
    }

    public function register(array $data): User
    {
        return User::create($data);
    }

    public function generateToken(Authenticatable $user): string
    {
        return $user->createToken('api')->plainTextToken;
    }

    public function logout(Authenticatable $user): void
    {
        $user->currentAccessToken()?->delete();
    }
}

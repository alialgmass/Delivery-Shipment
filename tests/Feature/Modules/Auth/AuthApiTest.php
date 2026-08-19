<?php

namespace Tests\Feature\Modules\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertOk()
            ->assertJsonPath('status', true)
            ->assertJsonPath('message', 'Registration successful.')
            ->assertJsonStructure([
                'body' => [
                    'accessToken',
                    'user' => ['id', 'name', 'email'],
                ],
            ]);

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_user_can_login(): void
    {
        $user = User::factory()->create(['password' => 'password123']);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertOk()
            ->assertJsonPath('status', true)
            ->assertJsonPath('message', 'Login successful.')
            ->assertJsonStructure(['body' => ['accessToken']]);
    }

    public function test_login_with_invalid_credentials_is_rejected(): void
    {
        $user = User::factory()->create();

        $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])->assertStatus(401)
            ->assertJsonPath('status', false)
            ->assertJsonPath('custom_code', 4001);
    }

    public function test_register_with_duplicate_email_is_rejected(): void
    {
        $user = User::factory()->create();

        $this->postJson('/api/v1/auth/register', [
            'name' => 'Test User',
            'email' => $user->email,
            'password' => 'password123',
        ])->assertStatus(400)
            ->assertJsonPath('status', false)
            ->assertJsonPath('custom_code', 4000);
    }

    public function test_authenticated_user_can_fetch_profile(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('api')->plainTextToken;

        $this->withToken($token)->getJson('/api/v1/auth/user')
            ->assertOk()
            ->assertJsonPath('body.user.email', $user->email);
    }

    public function test_profile_requires_authentication(): void
    {
        $this->getJson('/api/v1/auth/user')->assertStatus(401);
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('api')->plainTextToken;

        $this->withToken($token)->postJson('/api/v1/auth/logout')->assertOk();

        $this->assertDatabaseCount('personal_access_tokens', 0);
    }
}

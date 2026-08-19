<?php

namespace Tests\Feature\Modules\Delivery;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Delivery\Models\Carrier;
use Tests\TestCase;

class CarrierApiTest extends TestCase
{
    use RefreshDatabase;

    private function actingUser(): User
    {
        $user = User::factory()->create();
        $this->withToken($user->createToken('api')->plainTextToken);

        return $user;
    }

    public function test_user_can_create_carrier(): void
    {
        $this->actingUser();

        $response = $this->postJson('/api/delivery/v1/carriers', [
            'name' => 'Fast Express',
            'phone' => '01012345678',
            'vehicle_number' => 'AB-1234',
        ]);

        $response->assertOk()
            ->assertJsonPath('status', true)
            ->assertJsonPath('message', 'Carrier created successfully.')
            ->assertJsonPath('body.carrier.name', 'Fast Express');

        $this->assertDatabaseHas('carriers', ['name' => 'Fast Express']);
    }

    public function test_carrier_name_is_required(): void
    {
        $this->actingUser();

        $this->postJson('/api/delivery/v1/carriers', ['name' => ''])
            ->assertStatus(400)
            ->assertJsonPath('status', false)
            ->assertJsonPath('custom_code', 4000);
    }

    public function test_user_can_list_carriers_with_search(): void
    {
        $this->actingUser();
        Carrier::factory()->create(['name' => 'Alpha Express']);
        Carrier::factory()->create(['name' => 'Beta Cargo']);

        $this->getJson('/api/delivery/v1/carriers?search=Alpha')
            ->assertOk()
            ->assertJsonCount(1, 'body.carriers.data')
            ->assertJsonPath('body.carriers.data.0.name', 'Alpha Express');
    }

    public function test_listing_carriers_requires_authentication(): void
    {
        $this->getJson('/api/delivery/v1/carriers')->assertStatus(401);
    }

    public function test_creating_carriers_requires_authentication(): void
    {
        $this->postJson('/api/delivery/v1/carriers', ['name' => 'Fast Express'])->assertStatus(401);
    }
}

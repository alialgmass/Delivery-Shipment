<?php

namespace Tests\Feature\Modules\Shipment;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Delivery\Models\Carrier;
use Modules\Shipment\Models\Shipment;
use Tests\TestCase;

class ShipmentApiTest extends TestCase
{
    use RefreshDatabase;

    private function actingUser(): User
    {
        $user = User::factory()->create();
        $this->withToken($user->createToken('api')->plainTextToken);

        return $user;
    }

    private function shipmentPayload(array $overrides = []): array
    {
        return array_merge([
            'sender_address' => 'Cairo, Egypt',
            'recipient_name' => 'Ahmed Ali',
            'recipient_phone' => '01012345678',
            'recipient_address' => 'Alexandria, Egypt',
            'weight_kg' => 2.5,
            'cod_amount' => 150.00,
            'description' => 'Fragile package',
        ], $overrides);
    }

    public function test_user_can_create_shipment(): void
    {
        $user = $this->actingUser();

        $response = $this->postJson('/api/shipment/shipments', $this->shipmentPayload());

        $response->assertOk()
            ->assertJsonPath('status', true)
            ->assertJsonPath('message', 'Shipment created successfully.')
            ->assertJsonStructure([
                'body' => [
                    'shipment' => ['tracking_code', 'status', 'status_histories'],
                ],
            ]);

        $trackingCode = $response->json('body.shipment.tracking_code');

        $this->assertMatchesRegularExpression('/^DS-[A-Z0-9]{8}$/', $trackingCode);
        $this->assertDatabaseHas('shipments', [
            'tracking_code' => $trackingCode,
            'customer_id' => $user->id,
            'status' => 'pending',
        ]);
        $this->assertDatabaseHas('shipment_status_histories', [
            'status' => 'pending',
        ]);
    }

    public function test_creating_shipment_requires_required_fields(): void
    {
        $this->actingUser();

        $this->postJson('/api/shipment/shipments', [])
            ->assertStatus(400)
            ->assertJsonPath('status', false)
            ->assertJsonPath('custom_code', 4000);
    }

    public function test_user_can_list_only_own_shipments(): void
    {
        $user = $this->actingUser();
        Shipment::factory()->count(2)->create(['customer_id' => $user->id]);
        Shipment::factory()->create(['customer_id' => User::factory()->create()->id]);

        $this->getJson('/api/shipment/shipments')
            ->assertOk()
            ->assertJsonCount(2, 'body.shipments.data');
    }

    public function test_user_can_filter_shipments_by_status_and_search(): void
    {
        $user = $this->actingUser();
        Shipment::factory()->create([
            'customer_id' => $user->id,
            'tracking_code' => 'DS-ABC12345',
        ]);
        Shipment::factory()->delivered()->create([
            'customer_id' => $user->id,
            'tracking_code' => 'DS-XYZ99999',
        ]);

        $this->getJson('/api/shipment/shipments?status=delivered&search=XYZ')
            ->assertOk()
            ->assertJsonCount(1, 'body.shipments.data')
            ->assertJsonPath('body.shipments.data.0.tracking_code', 'DS-XYZ99999')
            ->assertJsonPath('body.shipments.data.0.status', 'delivered');
    }

    public function test_user_can_view_own_shipment_with_tracking_timeline(): void
    {
        $user = $this->actingUser();
        $shipment = Shipment::factory()->create(['customer_id' => $user->id]);

        $this->getJson("/api/shipment/shipments/{$shipment->id}")
            ->assertOk()
            ->assertJsonPath('body.shipment.id', $shipment->id)
            ->assertJsonPath('body.shipment.tracking_code', $shipment->tracking_code)
            ->assertJsonCount(0, 'body.shipment.status_histories');
    }

    public function test_user_cannot_view_another_users_shipment(): void
    {
        $this->actingUser();
        $shipment = Shipment::factory()->create();

        $this->getJson("/api/shipment/shipments/{$shipment->id}")
            ->assertStatus(403)
            ->assertJsonPath('status', false)
            ->assertJsonPath('custom_code', 4003);
    }

    public function test_showing_missing_shipment_returns_404(): void
    {
        $this->actingUser();

        $this->getJson('/api/shipment/shipments/9999')
            ->assertStatus(404)
            ->assertJsonPath('custom_code', 4002);
    }

    public function test_tracking_code_is_publicly_trackable(): void
    {
        $user = User::factory()->create();
        $shipment = Shipment::factory()->create(['customer_id' => $user->id]);

        $this->getJson("/api/shipment/track/{$shipment->tracking_code}")
            ->assertOk()
            ->assertJsonPath('body.shipment.tracking_code', $shipment->tracking_code);
    }

    public function test_tracking_with_unknown_code_returns_404(): void
    {
        $this->getJson('/api/shipment/track/DS-NOTFOUND')
            ->assertStatus(404)
            ->assertJsonPath('custom_code', 4002);
    }

    public function test_status_can_be_updated_through_valid_transition(): void
    {
        $user = $this->actingUser();
        $shipment = Shipment::factory()->create(['customer_id' => $user->id]);

        $this->patchJson("/api/shipment/shipments/{$shipment->id}/status", [
            'status' => 'picked_up',
            'note' => 'Picked up from warehouse',
            'location' => 'Cairo',
        ])->assertOk()
            ->assertJsonPath('body.shipment.status', 'picked_up');

        $this->assertDatabaseHas('shipments', [
            'id' => $shipment->id,
            'status' => 'picked_up',
        ]);
        $this->assertNotNull($shipment->fresh()->picked_up_at);
        $this->assertDatabaseHas('shipment_status_histories', [
            'shipment_id' => $shipment->id,
            'status' => 'picked_up',
            'note' => 'Picked up from warehouse',
            'location' => 'Cairo',
        ]);
    }

    public function test_invalid_status_transition_is_rejected(): void
    {
        $user = $this->actingUser();
        $shipment = Shipment::factory()->create(['customer_id' => $user->id]);

        $this->patchJson("/api/shipment/shipments/{$shipment->id}/status", ['status' => 'delivered'])
            ->assertStatus(400)
            ->assertJsonPath('status', false)
            ->assertJsonPath('custom_code', 4005);

        $this->assertDatabaseHas('shipments', [
            'id' => $shipment->id,
            'status' => 'pending',
        ]);
    }

    public function test_updating_to_same_status_is_rejected(): void
    {
        $user = $this->actingUser();
        $shipment = Shipment::factory()->create(['customer_id' => $user->id]);

        $this->patchJson("/api/shipment/shipments/{$shipment->id}/status", ['status' => 'pending'])
            ->assertStatus(400)
            ->assertJsonPath('custom_code', 4004);
    }

    public function test_delivered_status_sets_delivered_at(): void
    {
        $user = $this->actingUser();
        $shipment = Shipment::factory()->outForDelivery()->create(['customer_id' => $user->id]);

        $this->patchJson("/api/shipment/shipments/{$shipment->id}/status", ['status' => 'delivered'])
            ->assertOk()
            ->assertJsonPath('body.shipment.status', 'delivered');

        $this->assertNotNull($shipment->fresh()->delivered_at);
    }

    public function test_cancelling_an_active_shipment(): void
    {
        $user = $this->actingUser();
        $shipment = Shipment::factory()->create(['customer_id' => $user->id]);

        $this->postJson("/api/shipment/shipments/{$shipment->id}/cancel", ['note' => 'Customer changed mind'])
            ->assertOk()
            ->assertJsonPath('body.shipment.status', 'cancelled');

        $this->assertNotNull($shipment->fresh()->cancelled_at);
        $this->assertDatabaseHas('shipment_status_histories', [
            'shipment_id' => $shipment->id,
            'status' => 'cancelled',
            'note' => 'Customer changed mind',
        ]);
    }

    public function test_cancelling_a_delivered_shipment_is_rejected(): void
    {
        $user = $this->actingUser();
        $shipment = Shipment::factory()->delivered()->create(['customer_id' => $user->id]);

        $this->postJson("/api/shipment/shipments/{$shipment->id}/cancel")
            ->assertStatus(400)
            ->assertJsonPath('custom_code', 4005);
    }

    public function test_carrier_can_be_assigned_to_shipment(): void
    {
        $user = $this->actingUser();
        $shipment = Shipment::factory()->create(['customer_id' => $user->id]);
        $carrier = Carrier::factory()->create();

        $this->patchJson("/api/shipment/shipments/{$shipment->id}/carrier", ['carrier_id' => $carrier->id])
            ->assertOk()
            ->assertJsonPath('body.shipment.carrier.id', $carrier->id);

        $this->assertDatabaseHas('shipments', [
            'id' => $shipment->id,
            'carrier_id' => $carrier->id,
        ]);
    }

    public function test_assigning_missing_carrier_returns_404(): void
    {
        $this->actingUser();
        $shipment = Shipment::factory()->create();

        $this->patchJson("/api/shipment/shipments/{$shipment->id}/carrier", ['carrier_id' => 9999])
            ->assertStatus(400)
            ->assertJsonPath('custom_code', 4000);
    }

    public function test_shipment_endpoints_require_authentication(): void
    {
        $this->postJson('/api/shipment/shipments', $this->shipmentPayload())->assertStatus(401);
        $this->getJson('/api/shipment/shipments')->assertStatus(401);
        $this->getJson('/api/shipment/shipments/1')->assertStatus(401);
    }
}

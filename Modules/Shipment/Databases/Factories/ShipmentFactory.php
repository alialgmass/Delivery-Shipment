<?php

namespace Modules\Shipment\Databases\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Shipment\Enums\ShipmentStatusEnum;
use Modules\Shipment\Models\Shipment;

/**
 * @extends Factory<Shipment>
 */
class ShipmentFactory extends Factory
{
    protected $model = Shipment::class;

    public function definition(): array
    {
        return [
            'tracking_code' => 'DS-'.strtoupper(Str::random(8)),
            'customer_id' => User::factory(),
            'carrier_id' => null,
            'sender_address' => fake()->address(),
            'recipient_name' => fake()->name(),
            'recipient_phone' => fake()->numerify('##########'),
            'recipient_address' => fake()->address(),
            'weight_kg' => fake()->randomFloat(2, 0.5, 50),
            'cod_amount' => fake()->optional()->randomFloat(2, 10, 500),
            'description' => fake()->optional()->sentence(),
            'status' => ShipmentStatusEnum::Pending->value,
        ];
    }

    public function pickedUp(): static
    {
        return $this->state(fn () => [
            'status' => ShipmentStatusEnum::PickedUp->value,
            'picked_up_at' => now(),
        ]);
    }

    public function inTransit(): static
    {
        return $this->state(fn () => ['status' => ShipmentStatusEnum::InTransit->value]);
    }

    public function outForDelivery(): static
    {
        return $this->state(fn () => ['status' => ShipmentStatusEnum::OutForDelivery->value]);
    }

    public function delivered(): static
    {
        return $this->state(fn () => [
            'status' => ShipmentStatusEnum::Delivered->value,
            'delivered_at' => now(),
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn () => [
            'status' => ShipmentStatusEnum::Cancelled->value,
            'cancelled_at' => now(),
        ]);
    }
}

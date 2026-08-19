<?php

namespace Modules\Delivery\Databases\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Delivery\Models\Carrier;

/**
 * @extends Factory<Carrier>
 */
class CarrierFactory extends Factory
{
    protected $model = Carrier::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'phone' => fake()->numerify('##########'),
            'vehicle_number' => fake()->optional()->regexify('[A-Z]{2}-[0-9]{4}'),
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn () => ['is_active' => false]);
    }
}

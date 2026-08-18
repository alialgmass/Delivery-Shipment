<?php

namespace Modules\Country\Databases\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Country\Models\Country;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Country\Models\Country>
 */
class CountryFactory extends Factory
{
    protected $model = Country::class;

    public function definition(): array
    {
        return [
            'name' => [
                'en' => $this->faker->unique()->country(),
                'ar' => $this->faker->unique()->country(),
            ],
            'code' => $this->faker->unique()->countryCode(),
            'phone_code' => $this->faker->randomElement(['+1', '+44', '+33', '+49', '+971', '+966']),
        ];
    }
}

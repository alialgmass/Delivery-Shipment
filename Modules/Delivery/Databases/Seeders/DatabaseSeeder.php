<?php

namespace Modules\Delivery\Databases\Seeders;

use Illuminate\Database\Seeder;
use Modules\Delivery\Models\Carrier;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Carrier::factory()->count(3)->create();
    }
}

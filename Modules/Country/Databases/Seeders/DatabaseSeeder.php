<?php

namespace Modules\Country\Databases\Seeders;

use Illuminate\Database\Seeder;
use Modules\Country\Models\Country;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::factory()->count(10)->create();
    }
}

<?php

namespace Modules\Shipment\Databases\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Shipment\Models\Shipment;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = User::query()->first();

        if (! $customer) {
            return;
        }

        Shipment::factory()
            ->count(5)
            ->create(['customer_id' => $customer->id])
            ->each(function (Shipment $shipment) {
                $shipment->statusHistories()->create([
                    'status' => $shipment->status->value,
                ]);
            });
    }
}

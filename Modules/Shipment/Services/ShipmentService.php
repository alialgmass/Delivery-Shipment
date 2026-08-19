<?php

namespace Modules\Shipment\Services;

use App\Exceptions\ApiException\ExceptionResponse;
use App\Support\Traits\MakeAble;
use Illuminate\Support\Str;
use Modules\Delivery\Models\Carrier;
use Modules\Shipment\Enums\ShipmentStatusEnum;
use Modules\Shipment\Models\Shipment;

class ShipmentService
{
    use MakeAble;

    public function create(array $data): Shipment
    {
        $data['tracking_code'] = $this->generateTrackingCode();
        $data['customer_id'] = user('id');
        $data['status'] = ShipmentStatusEnum::Pending->value;

        $shipment = Shipment::create($data);
        $this->recordStatus($shipment, ShipmentStatusEnum::Pending);

        return $shipment;
    }

    /**
     * @throws ExceptionResponse
     */
    public function updateStatus(
        Shipment $shipment,
        ShipmentStatusEnum $status,
        ?string $note = null,
        ?string $location = null
    ): Shipment {
        $current = $shipment->status->value;

        if ($current === $status->value) {
            throw ExceptionResponse::instance("Shipment is already {$status->value}.")->setCustomCode(4004);
        }

        if (! ShipmentStatusEnum::canTransition($current, $status->value)) {
            throw ExceptionResponse::instance(
                "Cannot transition shipment from {$current} to {$status->value}."
            )->setCustomCode(4005);
        }

        $data = ['status' => $status->value];

        $timestamps = [
            ShipmentStatusEnum::PickedUp->value => 'picked_up_at',
            ShipmentStatusEnum::Delivered->value => 'delivered_at',
            ShipmentStatusEnum::Cancelled->value => 'cancelled_at',
        ];

        if (isset($timestamps[$status->value])) {
            $data[$timestamps[$status->value]] = now();
        }

        $shipment->update($data);
        $this->recordStatus($shipment, $status, $note, $location);

        return $shipment;
    }

    /**
     * @throws ExceptionResponse
     */
    public function cancel(Shipment $shipment, ?string $note = null): Shipment
    {
        return $this->updateStatus($shipment, ShipmentStatusEnum::Cancelled, $note);
    }

    public function assignCarrier(Shipment $shipment, Carrier $carrier): Shipment
    {
        $shipment->update(['carrier_id' => $carrier->id]);

        return $shipment;
    }

    private function generateTrackingCode(): string
    {
        do {
            $code = 'DS-'.strtoupper(Str::random(8));
        } while (Shipment::query()->where('tracking_code', $code)->exists());

        return $code;
    }

    private function recordStatus(
        Shipment $shipment,
        ShipmentStatusEnum $status,
        ?string $note = null,
        ?string $location = null
    ): void {
        $shipment->statusHistories()->create([
            'status' => $status->value,
            'note' => $note,
            'location' => $location,
        ]);
    }
}

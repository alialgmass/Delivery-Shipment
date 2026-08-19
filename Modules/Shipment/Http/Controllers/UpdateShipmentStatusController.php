<?php

namespace Modules\Shipment\Http\Controllers;

use App\Exceptions\ApiException\ExceptionResponse;
use App\Http\Controllers\Api\ApiController;
use Modules\Shipment\Enums\ShipmentStatusEnum;
use Modules\Shipment\Http\Requests\UpdateShipmentStatusRequest;
use Modules\Shipment\Http\Resources\ShipmentResource;
use Modules\Shipment\Models\Shipment;
use Modules\Shipment\Services\ShipmentService;

class UpdateShipmentStatusController extends ApiController
{
    public function __invoke(UpdateShipmentStatusRequest $request, ShipmentService $service)
    {
        $shipment = Shipment::query()->find($request->route('shipment'));

        if (! $shipment) {
            throw ExceptionResponse::instance('Shipment not found.', 404)->setCustomCode(4002);
        }

        $shipment = $service->updateStatus(
            $shipment,
            ShipmentStatusEnum::from($request->validated('status')),
            $request->validated('note'),
            $request->validated('location')
        );

        $shipment->load('customer', 'carrier', 'statusHistories');

        return $this->apiMessage('Shipment status updated successfully.')
            ->apiBody([
                'shipment' => ShipmentResource::make($shipment),
            ])->apiResponse();
    }
}

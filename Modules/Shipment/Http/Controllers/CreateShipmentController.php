<?php

namespace Modules\Shipment\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use Modules\Shipment\Http\Requests\StoreShipmentRequest;
use Modules\Shipment\Http\Resources\ShipmentResource;
use Modules\Shipment\Services\ShipmentService;

class CreateShipmentController extends ApiController
{
    public function __invoke(StoreShipmentRequest $request, ShipmentService $service)
    {
        $shipment = $service->create($request->validated());
        $shipment->load('customer', 'carrier', 'statusHistories');

        return $this->apiMessage('Shipment created successfully.')
            ->apiBody([
                'shipment' => ShipmentResource::make($shipment),
            ])->apiResponse();
    }
}

<?php

namespace Modules\Shipment\Http\Controllers;

use App\Exceptions\ApiException\ExceptionResponse;
use App\Http\Controllers\Api\ApiController;
use Modules\Shipment\Http\Requests\CancelShipmentRequest;
use Modules\Shipment\Http\Resources\ShipmentResource;
use Modules\Shipment\Models\Shipment;
use Modules\Shipment\Services\ShipmentService;

class CancelShipmentController extends ApiController
{
    public function __invoke(CancelShipmentRequest $request, ShipmentService $service)
    {
        $shipment = Shipment::query()->find($request->route('shipment'));

        if (! $shipment) {
            throw ExceptionResponse::instance('Shipment not found.', 404)->setCustomCode(4002);
        }

        $shipment = $service->cancel($shipment, $request->validated('note'));
        $shipment->load('customer', 'carrier', 'statusHistories');

        return $this->apiMessage('Shipment cancelled successfully.')
            ->apiBody([
                'shipment' => ShipmentResource::make($shipment),
            ])->apiResponse();
    }
}

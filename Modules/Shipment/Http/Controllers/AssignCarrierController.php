<?php

namespace Modules\Shipment\Http\Controllers;

use App\Exceptions\ApiException\ExceptionResponse;
use App\Http\Controllers\Api\ApiController;
use Modules\Delivery\Models\Carrier;
use Modules\Shipment\Http\Requests\AssignCarrierRequest;
use Modules\Shipment\Http\Resources\ShipmentResource;
use Modules\Shipment\Models\Shipment;
use Modules\Shipment\Services\ShipmentService;

class AssignCarrierController extends ApiController
{
    public function __invoke(AssignCarrierRequest $request, ShipmentService $service)
    {
        $shipment = Shipment::query()->find($request->route('shipment'));

        if (! $shipment) {
            throw ExceptionResponse::instance('Shipment not found.', 404)->setCustomCode(4002);
        }

        $carrier = Carrier::query()->find($request->validated('carrier_id'));

        if (! $carrier) {
            throw ExceptionResponse::instance('Carrier not found.', 404)->setCustomCode(4002);
        }

        $shipment = $service->assignCarrier($shipment, $carrier);
        $shipment->load('customer', 'carrier');

        return $this->apiMessage('Carrier assigned successfully.')
            ->apiBody([
                'shipment' => ShipmentResource::make($shipment),
            ])->apiResponse();
    }
}

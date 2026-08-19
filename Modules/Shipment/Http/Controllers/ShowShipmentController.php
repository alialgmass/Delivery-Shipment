<?php

namespace Modules\Shipment\Http\Controllers;

use App\Exceptions\ApiException\ExceptionResponse;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Modules\Shipment\Http\Resources\ShipmentResource;
use Modules\Shipment\Models\Shipment;

class ShowShipmentController extends ApiController
{
    public function __invoke(int $shipment, Request $request)
    {
        $shipment = Shipment::query()->with('customer', 'carrier')->find($shipment);

        if (! $shipment) {
            throw ExceptionResponse::instance('Shipment not found.', 404)->setCustomCode(4002);
        }

        if ((int) $shipment->customer_id !== (int) user('id')) {
            throw ExceptionResponse::instance('You are not authorized to view this shipment.', 403)->setCustomCode(4003);
        }

        $shipment->setRelation('statusHistories', $shipment->statusHistories()
            ->orderByDesc('created_at')
            ->paginate($this->resolvePerPage($request)));

        return $this->apiBody([
            'shipment' => ShipmentResource::make($shipment),
        ])->apiResponse();
    }
}

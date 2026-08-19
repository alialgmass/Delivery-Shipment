<?php

namespace Modules\Shipment\Http\Controllers;

use App\Exceptions\ApiException\ExceptionResponse;
use App\Http\Controllers\Api\ApiController;
use Modules\Shipment\Http\Resources\ShipmentResource;
use Modules\Shipment\Models\Shipment;

class TrackShipmentController extends ApiController
{
    public function __invoke(string $tracking_code)
    {
        $shipment = Shipment::query()
            ->with('statusHistories')
            ->where('tracking_code', $tracking_code)
            ->first();

        if (! $shipment) {
            throw ExceptionResponse::instance('Shipment not found with this tracking code.', 404)->setCustomCode(4002);
        }

        return $this->apiBody([
            'shipment' => ShipmentResource::make($shipment),
        ])->apiResponse();
    }
}

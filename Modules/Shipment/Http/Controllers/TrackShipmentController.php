<?php

namespace Modules\Shipment\Http\Controllers;

use App\Exceptions\ApiException\ExceptionResponse;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Modules\Shipment\Http\Resources\ShipmentResource;
use Modules\Shipment\Models\Shipment;

class TrackShipmentController extends ApiController
{
    public function __invoke(string $tracking_code, Request $request)
    {
        $shipment = Shipment::query()
            ->where('tracking_code', $tracking_code)
            ->first();

        if (! $shipment) {
            throw ExceptionResponse::instance('Shipment not found with this tracking code.', 404)->setCustomCode(4002);
        }

        $shipment->setRelation('statusHistories', $shipment->statusHistories()
            ->orderByDesc('created_at')
            ->paginate($this->resolvePerPage($request)));

        return $this->apiBody([
            'shipment' => ShipmentResource::make($shipment),
        ])->apiResponse();
    }
}

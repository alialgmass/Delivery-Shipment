<?php

namespace Modules\Shipment\Http\Controllers;

use App\Exceptions\ApiException\ExceptionResponse;
use App\Http\Controllers\Api\ApiController;
use Modules\Shipment\Http\Requests\IndexShipmentHistoriesRequest;
use Modules\Shipment\Http\Resources\ShipmentStatusHistoryResource;
use Modules\Shipment\Models\Shipment;

class ListShipmentHistoriesController extends ApiController
{
    public function __invoke(int $shipment, IndexShipmentHistoriesRequest $request)
    {
        $shipmentModel = Shipment::query()->find($shipment);

        if (! $shipmentModel) {
            throw ExceptionResponse::instance('Shipment not found.', 404)->setCustomCode(4002);
        }

        if ((int) $shipmentModel->customer_id !== (int) user('id')) {
            throw ExceptionResponse::instance('You are not authorized to view this shipment.', 403)->setCustomCode(4003);
        }

        $histories = $shipmentModel->statusHistories()
            ->orderByDesc('created_at')
            ->paginate($request->validated('per_page', 10));

        return $this->apiBody([
            'status_histories' => ShipmentStatusHistoryResource::paginate($histories),
        ])->apiResponse();
    }
}
<?php

namespace Modules\Shipment\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Modules\Shipment\Filters\FilterByStatus;
use Modules\Shipment\Http\Requests\IndexShipmentRequest;
use Modules\Shipment\Http\Resources\ShipmentResource;
use Modules\Shipment\Models\Shipment;

class ListShipmentsController extends ApiController
{
    public function __invoke(IndexShipmentRequest $request)
    {
        $search = $request->validated('search');

        $shipments = Shipment::query()
            ->with('customer', 'carrier')
            ->filter([
                new FilterByStatus($request->validated('status')),
            ])
            ->where('customer_id', user('id'))
            ->when($search, function (Builder $query, string $search) {
                $escaped = addcslashes($search, '%_\\');

                return $query->where('tracking_code', 'like', "%{$escaped}%");
            })
            ->paginate($request->validated('per_page', 10));

        return $this->apiBody([
            'shipments' => ShipmentResource::paginate($shipments),
        ])->apiResponse();
    }
}

<?php

namespace Modules\Delivery\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use Modules\Delivery\Http\Requests\StoreCarrierRequest;
use Modules\Delivery\Http\Resources\CarrierResource;
use Modules\Delivery\Models\Carrier;

class CreateCarrierController extends ApiController
{
    public function __invoke(StoreCarrierRequest $request)
    {
        $carrier = Carrier::create($request->validated());

        return $this->apiMessage('Carrier created successfully.')
            ->apiBody([
                'carrier' => CarrierResource::make($carrier),
            ])->apiResponse();
    }
}

<?php

namespace Modules\Shipment\Http\Requests;

use App\Http\Requests\BaseRequest;
use Modules\Shipment\Enums\ShipmentStatusEnum;

class UpdateShipmentStatusRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'status' => 'required|string|in:'.implode(',', ShipmentStatusEnum::values()),
            'note' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:255',
        ];
    }
}

<?php

namespace Modules\Shipment\Http\Requests;

use App\Http\Requests\BaseRequest;
use Modules\Shipment\Enums\ShipmentStatusEnum;

class IndexShipmentRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'status' => 'nullable|string|in:'.implode(',', ShipmentStatusEnum::values()),
            'search' => 'nullable|string|max:20',
            'per_page' => 'nullable|integer|min:1|max:100',
        ];
    }
}

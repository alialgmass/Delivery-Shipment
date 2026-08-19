<?php

namespace Modules\Shipment\Http\Requests;

use App\Http\Requests\BaseRequest;

class CancelShipmentRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'note' => 'nullable|string|max:1000',
        ];
    }
}

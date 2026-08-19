<?php

namespace Modules\Shipment\Http\Requests;

use App\Http\Requests\BaseRequest;

class AssignCarrierRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'carrier_id' => 'required|integer|exists:carriers,id',
        ];
    }
}

<?php

namespace Modules\Shipment\Http\Requests;

use App\Http\Requests\BaseRequest;

class StoreShipmentRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'sender_address' => 'required|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:30',
            'recipient_address' => 'required|string|max:255',
            'weight_kg' => 'nullable|numeric|min:0|max:999999.99',
            'cod_amount' => 'nullable|numeric|min:0|max:99999999.99',
            'description' => 'nullable|string|max:1000',
        ];
    }
}

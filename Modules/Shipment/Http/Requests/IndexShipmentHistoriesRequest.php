<?php

namespace Modules\Shipment\Http\Requests;

use App\Http\Requests\BaseRequest;

class IndexShipmentHistoriesRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'per_page' => 'nullable|integer|min:1|max:100',
        ];
    }
}
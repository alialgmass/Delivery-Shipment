<?php

namespace Modules\Delivery\Http\Requests;

use App\Http\Requests\BaseRequest;

class StoreCarrierRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'vehicle_number' => 'nullable|string|max:30',
            'is_active' => 'nullable|boolean',
        ];
    }
}

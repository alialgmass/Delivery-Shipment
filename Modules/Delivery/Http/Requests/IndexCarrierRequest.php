<?php

namespace Modules\Delivery\Http\Requests;

use App\Http\Requests\BaseRequest;

class IndexCarrierRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'search' => 'nullable|string|max:255',
            'per_page' => 'nullable|integer|min:1|max:100',
        ];
    }
}

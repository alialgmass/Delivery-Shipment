<?php

namespace Modules\Delivery\Http\Resources;

use App\Support\Api\Resources\WithPagination;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Delivery\Models\Carrier;

/**
 * @mixin Carrier
 */
class CarrierResource extends JsonResource
{
    use WithPagination;

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'vehicle_number' => $this->vehicle_number,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}

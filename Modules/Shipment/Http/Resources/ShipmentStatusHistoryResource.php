<?php

namespace Modules\Shipment\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Shipment\Models\ShipmentStatusHistory;

/**
 * @mixin ShipmentStatusHistory
 */
class ShipmentStatusHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'note' => $this->note,
            'location' => $this->location,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}

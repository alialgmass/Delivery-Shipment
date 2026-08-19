<?php

namespace Modules\Shipment\Http\Resources;

use App\Support\Api\Resources\WithPagination;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Shipment\Models\ShipmentStatusHistory;

/**
 * @mixin ShipmentStatusHistory
 */
class ShipmentStatusHistoryResource extends JsonResource
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
            'status' => $this->status,
            'note' => $this->note,
            'location' => $this->location,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}

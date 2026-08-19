<?php

namespace Modules\Shipment\Http\Resources;

use App\Support\Api\Resources\WithPagination;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Delivery\Http\Resources\CarrierResource;
use Modules\Shipment\Models\Shipment;
use Modules\User\Http\Resources\UserResource;

/**
 * @mixin Shipment
 */
class ShipmentResource extends JsonResource
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
            'tracking_code' => $this->tracking_code,
            'status' => $this->status->value,
            'sender_address' => $this->sender_address,
            'recipient_name' => $this->recipient_name,
            'recipient_phone' => $this->recipient_phone,
            'recipient_address' => $this->recipient_address,
            'weight_kg' => $this->weight_kg,
            'cod_amount' => $this->cod_amount,
            'description' => $this->description,
            'picked_up_at' => $this->picked_up_at?->toDateTimeString(),
            'delivered_at' => $this->delivered_at?->toDateTimeString(),
            'cancelled_at' => $this->cancelled_at?->toDateTimeString(),
            'created_at' => $this->created_at?->toDateTimeString(),
            'customer' => UserResource::make($this->whenLoaded('customer')),
            'carrier' => CarrierResource::make($this->whenLoaded('carrier')),
            'status_histories' => ShipmentStatusHistoryResource::paginate($this->whenLoaded('statusHistories')),
        ];
    }
}

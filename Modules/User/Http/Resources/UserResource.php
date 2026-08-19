<?php

namespace Modules\User\Http\Resources;

use App\Support\Api\Resources\WithPagination;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Models\User;

/**
 * @mixin User
 */
class UserResource extends JsonResource
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
            'email' => $this->email,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}

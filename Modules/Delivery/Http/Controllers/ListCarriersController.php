<?php

namespace Modules\Delivery\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Modules\Delivery\Http\Requests\IndexCarrierRequest;
use Modules\Delivery\Http\Resources\CarrierResource;
use Modules\Delivery\Models\Carrier;

class ListCarriersController extends ApiController
{
    public function __invoke(IndexCarrierRequest $request)
    {
        $search = $request->validated('search');

        $carriers = Carrier::query()
            ->when($search, function (Builder $query, string $search) {
                $escaped = addcslashes($search, '%_\\');

                return $query->where('name', 'like', "%{$escaped}%");
            })
            ->paginate($request->validated('per_page', 10));

        return $this->apiBody([
            'carriers' => CarrierResource::paginate($carriers),
        ])->apiResponse();
    }
}

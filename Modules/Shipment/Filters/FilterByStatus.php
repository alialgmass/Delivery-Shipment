<?php

namespace Modules\Shipment\Filters;

use App\Support\Contracts\Filters\FilterContract;
use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder;

class FilterByStatus implements FilterContract
{
    public function __construct(private readonly ?string $status = null) {}

    public function handle(Builder $query, Closure $next)
    {
        if ($this->status) {
            $query->where('status', $this->status);
        }

        return $next($query);
    }
}

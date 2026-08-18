<?php

namespace Modules\Shipment\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ModuleShipmentStatusMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! module_active('Shipment')) {
            abort(404, 'Shipment module disabled');
        }

        return $next($request);
    }
}

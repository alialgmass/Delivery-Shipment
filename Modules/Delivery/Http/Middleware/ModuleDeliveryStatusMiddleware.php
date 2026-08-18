<?php

namespace Modules\Delivery\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ModuleDeliveryStatusMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! module_active('Delivery')) {
            abort(404, 'Delivery module disabled');
        }

        return $next($request);
    }
}

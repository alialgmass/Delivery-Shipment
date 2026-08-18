<?php

namespace Modules\Admin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ModuleAdminStatusMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! module_active('Admin')) {
            abort(404, 'Admin module disabled');
        }

        return $next($request);
    }
}

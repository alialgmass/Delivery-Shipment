<?php

namespace Modules\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ModuleAuthStatusMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! module_active('Auth')) {
            abort(404, 'Auth module disabled');
        }

        return $next($request);
    }
}

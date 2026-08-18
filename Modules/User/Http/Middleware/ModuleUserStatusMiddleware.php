<?php

namespace Modules\User\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ModuleUserStatusMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! module_active('User')) {
            abort(404, 'User module disabled');
        }

        return $next($request);
    }
}

<?php

namespace Modules\Auth\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Middleware\ModuleAuthStatusMiddleware;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware(['web', ModuleAuthStatusMiddleware::class])
                ->group(module_path('auth', 'routes/web.php'));
        });
    }
}

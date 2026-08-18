<?php

namespace Modules\User\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\User\Http\Middleware\ModuleUserStatusMiddleware;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware(['web', ModuleUserStatusMiddleware::class])
                ->group(module_path('user', 'routes/web.php'));
        });
    }
}

<?php

namespace Modules\Admin\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Middleware\ModuleAdminStatusMiddleware;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware(['web', ModuleAdminStatusMiddleware::class])
                ->group(module_path('admin', 'routes/web.php'));
        });
    }
}

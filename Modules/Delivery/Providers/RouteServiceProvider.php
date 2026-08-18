<?php

namespace Modules\Delivery\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\Delivery\Http\Middleware\ModuleDeliveryStatusMiddleware;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware(['web', ModuleDeliveryStatusMiddleware::class])
                ->group(module_path('delivery', 'routes/web.php'));
        });
    }
}

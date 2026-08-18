<?php

namespace Modules\Shipment\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\Shipment\Http\Middleware\ModuleShipmentStatusMiddleware;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware(['web', ModuleShipmentStatusMiddleware::class])
                ->group(module_path('shipment', 'routes/web.php'));
        });
    }
}

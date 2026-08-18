<?php

namespace Modules\Country\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\Country\Http\Middleware\ModuleCountryStatusMiddleware;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->routes(function () {
            Route::middleware(['web', ModuleCountryStatusMiddleware::class])
                ->namespace($this->namespace)
                ->group(module_path('country', 'routes/web.php'));
        });
    }
}

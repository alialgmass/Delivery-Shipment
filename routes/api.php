<?php

use App\Http\Middleware\AcceptJsonMiddleware;
use App\Http\Middleware\AppLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/user', function (Request $request) {
    return $request;
});

foreach (module_name_lists() as $module) {
    $path = base_path("Modules/{$module}/routes/api.php");

    if (file_exists($path)) {
        Route::middleware([AcceptJsonMiddleware::class, AppLanguage::class])
            ->prefix(Str::of($module)->snake('-')->lower()->toString())
            ->as(Str::of($module)->snake('-')->lower()->append('.')->toString())
            ->group(function () use ($path) {
                require $path;
            });
    }
}

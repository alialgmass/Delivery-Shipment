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
    $moduleName = Str::of($module)->snake('-')->lower()->toString();
    $versionDir = base_path("Modules/{$module}/routes/api");

    if (! is_dir($versionDir)) {
        continue;
    }

    foreach (glob($versionDir.'/*.php') as $path) {
        $version = basename($path, '.php');

        Route::middleware([AcceptJsonMiddleware::class, AppLanguage::class])
            ->prefix("{$moduleName}/{$version}")
            ->as("{$moduleName}.")
            ->group(function () use ($path) {
                require $path;
            });
    }
}

<?php

use Illuminate\Support\Facades\Route;
use Modules\Delivery\Http\Controllers\CreateCarrierController;
use Modules\Delivery\Http\Controllers\ListCarriersController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('carriers', ListCarriersController::class)->name('carriers.index');
    Route::post('carriers', CreateCarrierController::class)->name('carriers.store');
});

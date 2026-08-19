<?php

use Illuminate\Support\Facades\Route;
use Modules\Shipment\Http\Controllers\AssignCarrierController;
use Modules\Shipment\Http\Controllers\CancelShipmentController;
use Modules\Shipment\Http\Controllers\CreateShipmentController;
use Modules\Shipment\Http\Controllers\ListShipmentsController;
use Modules\Shipment\Http\Controllers\ShowShipmentController;
use Modules\Shipment\Http\Controllers\TrackShipmentController;
use Modules\Shipment\Http\Controllers\UpdateShipmentStatusController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('shipments', CreateShipmentController::class)->name('shipments.store');
    Route::get('shipments', ListShipmentsController::class)->name('shipments.index');
    Route::get('shipments/{shipment}', ShowShipmentController::class)->name('shipments.show');
    Route::patch('shipments/{shipment}/status', UpdateShipmentStatusController::class)->name('shipments.update-status');
    Route::patch('shipments/{shipment}/carrier', AssignCarrierController::class)->name('shipments.assign-carrier');
    Route::post('shipments/{shipment}/cancel', CancelShipmentController::class)->name('shipments.cancel');
});

Route::get('track/{tracking_code}', TrackShipmentController::class)->name('track');

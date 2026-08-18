<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Shipment Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your module. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'shipment', 'as' => 'shipment.'], function () {
    Route::get('/', function () {
        return view('shipment::welcome');
    })->name('welcome');
});

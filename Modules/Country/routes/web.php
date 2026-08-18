<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Country Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your module. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'country', 'as' => 'country.'], function () {
    Route::get('/', function () {
        return view('country::welcome');
    })->name('welcome');
});

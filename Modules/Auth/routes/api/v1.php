<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthUserController;
use Modules\Auth\Http\Controllers\LoginController;
use Modules\Auth\Http\Controllers\LogoutController;
use Modules\Auth\Http\Controllers\RegisterController;

Route::post('login', LoginController::class)->name('login');
Route::post('register', RegisterController::class)->name('register');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', AuthUserController::class)->name('user');
    Route::post('logout', LogoutController::class)->name('logout');
});

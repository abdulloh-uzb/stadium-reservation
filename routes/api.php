<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\StadiumController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "API";
});

Route::apiResource('stadium', StadiumController::class);
Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]);

Route::post("/booking", [BookingController::class, "bookingStadium"])->middleware('auth:sanctum');
Route::get("/availibities/{id}", [BookingController::class, "getAvailabilities"]);


Route::post('/forgot-password', [PasswordResetController::class, "requestPasswordReset"]);

Route::post('/reset-password', [PasswordResetController::class, "resetPassword"])->name('password.reset');




<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\StadiumController;
use Illuminate\Support\Facades\Route;

Route::apiResource('stadium', StadiumController::class)->middleware("auth:sanctum");
Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]);

Route::post("/booking", [BookingController::class, "bookingStadium"])->middleware('auth:sanctum');
Route::get("/availibities/{id}", [BookingController::class, "getAvailabilities"])->middleware("auth:sanctum");

Route::post('/forgot-password', [PasswordResetController::class, "requestPasswordReset"]);
Route::post('/reset-password', [PasswordResetController::class, "resetPassword"])->name('password.reset');

Route::get("/reservations", [BookingController::class, "getReservations"])->middleware("auth:sanctum");
Route::post("/update-booking/{booking}", [BookingController::class, "updateBooking"])->middleware("auth:sanctum");


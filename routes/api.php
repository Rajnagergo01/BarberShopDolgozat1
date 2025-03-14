<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BarberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get("/barbers", [BarberController::class,"index"]);
Route::post("/barbers", [BarberController::class,"store"]);
Route::delete("/barbers", [BarberController::class,"destroy"]);

Route::get("/appointments", [AppointmentController::class,"index"]);
Route::post("/appointments", [AppointmentController::class,"store"]);
Route::delete("/appointments", [AppointmentController::class,"destroy"]);


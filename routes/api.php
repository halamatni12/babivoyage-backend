<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\AirlineController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [RegisterController::class, 'store']);
Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:10,1');


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy']);
    Route::get('/me', [LoginController::class, 'me']);
    Route::apiResource('destinations', DestinationController::class)->except(['index','show']);
    Route::apiResource('airlines',     AirlineController::class)->except(['index','show']);
    Route::apiResource('flights',      FlightController::class)->except(['index','show']);
    Route::get('bookings',        [BookingController::class, 'indexapi']);
    Route::post('bookings',       [BookingController::class, 'storeapi']);
    Route::get('bookings/{booking}', [BookingController::class, 'showapi']);
    Route::put('bookings/{booking}', [BookingController::class, 'update']);
    Route::delete('bookings/{booking}', [BookingController::class, 'destroy']);
    Route::get('payments', [PaymentController::class, 'index']);
    Route::post('payments', [PaymentController::class, 'storeapi']); // 👈 note storeapi
    Route::get('payments/{payment}', [PaymentController::class, 'show']);    Route::apiResource('reviews',      ReviewController::class)->only(['store','update','destroy']);
});

// Public reads
Route::apiResource('destinations', DestinationController::class)->only(['index','show']);
Route::apiResource('airlines',     AirlineController::class)->only(['index','show']);
Route::apiResource('flights',      FlightController::class)->only(['index','show']);
Route::get('/reviews/flight/{flight}', [ReviewController::class, 'indexByFlight']);
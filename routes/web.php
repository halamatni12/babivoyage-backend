<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightSearchController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
// Home
Route::get('/home', function () { return view('userside.home'); })->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Search results
Route::get('/flights', [FlightSearchController::class, 'results'])->name('flights.results');

// Login/Logout
Route::middleware('guest')->group(function () {
    Route::get('/login',  [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'loginWeb'])->name('login.post');

    // Register
    Route::get('/register',  [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'registerWeb'])->name('register.post');
});
Route::post('/logout', [LoginController::class, 'logoutWeb'])->middleware('auth')->name('logout');

// Booking (protected)
Route::middleware('auth')->group(function () {
    // Show all bookings for logged-in user
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');

    // Booking flow
    Route::get('/flights/{flight}/book',  [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/flights/{flight}/book', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}',     [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
});
use App\Http\Controllers\PaymentController;

Route::middleware('auth')->group(function () {
    Route::post('/flights/{flight}/book', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/payments/{booking}/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments/{booking}', [PaymentController::class, 'store'])->name('payments.store');
});
use App\Http\Controllers\FlightController;

Route::get('/flights/{flight}', [FlightController::class, 'showDetails'])
    ->name('flights.show');
Route::get('/destinations', [FlightController::class, 'indexdes'])->name('destinations.index');
Route::get('/flight/results', [FlightController::class, 'results'])
    ->name('flight.results');
<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Guest Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [BookingController::class, 'index'])->name('home');
Route::get('/rooms', [BookingController::class, 'rooms'])->name('rooms.index');
Route::get('/rooms/{roomType:slug}', [BookingController::class, 'showRoomType'])->name('rooms.show');
Route::get('/book/{room?}', [BookingController::class, 'book'])->name('booking.create');
Route::post('/book', [BookingController::class, 'store'])->name('booking.store');
Route::post('/book/calculate', [BookingController::class, 'calculate'])->name('booking.calculate');
Route::get('/booking/{code}', [BookingController::class, 'confirmation'])->name('booking.confirmation');
Route::post('/booking/{code}/pay', [BookingController::class, 'simulatePayment'])->name('booking.simulate_payment');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin / Staff Portal Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin,receptionist'])
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Room Status Grid
        Route::get('/rooms/status-grid', [RoomController::class, 'statusGrid'])->name('rooms.grid');
        Route::patch('/rooms/{id}/status', [RoomController::class, 'updateStatus'])->name('rooms.status');

        // Reservations
        Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
        Route::get('/reservations/{id}', [ReservationController::class, 'show'])->name('reservations.show');
        Route::patch('/reservations/{id}/check-in', [ReservationController::class, 'checkIn'])->name('reservations.check-in');
        Route::post('/reservations/{id}/services', [ReservationController::class, 'addService'])->name('reservations.services');
        Route::patch('/reservations/{id}/check-out', [ReservationController::class, 'checkOut'])->name('reservations.check-out');
        Route::get('/reservations/{id}/invoice', [ReservationController::class, 'invoice'])->name('reservations.invoice');
    });

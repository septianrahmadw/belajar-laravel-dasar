<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProdiController;
use App\Http\Controllers\Admin\AdminRoomController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RoomController::class, 'index'])->name('home');

Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
Route::get('/rooms/{room}/schedule', [RoomController::class, 'schedule'])->name('rooms.schedule');
Route::get('/rooms/{room}/month', [RoomController::class, 'monthSchedule'])->name('rooms.month-schedule');
Route::get('/rooms/{room}/check-availability', [RoomController::class, 'checkAvailability'])
    ->middleware('throttle:availability-check')
    ->name('rooms.check-availability');

Route::post('/bookings', [BookingController::class, 'store'])
    ->middleware('throttle:booking-create')
    ->name('bookings.store');

Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.my');
Route::post('/my-bookings/send-pin', [BookingController::class, 'sendPin'])
    ->middleware('throttle:booking-pin-send')
    ->name('bookings.verify.send');
Route::post('/my-bookings/verify-pin', [BookingController::class, 'verifyPin'])
    ->middleware('throttle:booking-pin-verify')
    ->name('bookings.verify.pin');

Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])
    ->middleware('throttle:booking-action')
    ->name('bookings.cancel');

Route::post('/bookings/{booking}/cancel-recurrence', [BookingController::class, 'cancelRecurrence'])
    ->middleware('throttle:booking-action')
    ->name('bookings.cancel-recurrence');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Admin & Operator: dashboard, rooms, bookings
    Route::middleware('operator')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('rooms', AdminRoomController::class)->except('show');
        Route::post('rooms/{room}/toggle', [AdminRoomController::class, 'toggle'])->name('rooms.toggle');

        Route::resource('prodis', AdminProdiController::class)->except('show');
        Route::post('prodis/{prodi}/toggle', [AdminProdiController::class, 'toggle'])->name('prodis.toggle');

        Route::get('schedule', [AdminBookingController::class, 'schedule'])->name('schedule');

        Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
        Route::get('bookings/export/pdf', [AdminBookingController::class, 'exportPdf'])->name('bookings.export.pdf');
        Route::get('bookings/export/csv', [AdminBookingController::class, 'exportCsv'])->name('bookings.export.csv');
        Route::get('bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
        Route::get('bookings/{booking}/edit', [AdminBookingController::class, 'edit'])->name('bookings.edit');
        Route::put('bookings/{booking}', [AdminBookingController::class, 'update'])->name('bookings.update');
        Route::post('bookings/{booking}/approve', [AdminBookingController::class, 'approve'])->name('bookings.approve');
        Route::post('bookings/{booking}/reject', [AdminBookingController::class, 'reject'])->name('bookings.reject');
        Route::post('bookings/{booking}/cancel-recurrence', [AdminBookingController::class, 'cancelRecurrence'])->name('bookings.cancel-recurrence');
        Route::delete('bookings/{booking}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');
        Route::delete('bookings/{booking}/force-delete', [AdminBookingController::class, 'forceDestroy'])->name('bookings.force-destroy');
    });

    // Admin only: user management
    Route::middleware('admin')->group(function () {
        Route::resource('users', AdminUserController::class)->except('show');
    });
});

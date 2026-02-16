<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReminderController;

Route::view('/', 'splash')->name('splash');

Route::view('/welcome', 'welcome')->name('welcome');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


// We'll add these pages next
// Route::get('/bookings/create', fn() => 'Booking form next')->name('bookings.create');
// Route::get('/reminders/create', fn() => 'Reminder form next')->name('reminders.create');

//Resource Routes
Route::resource('clinics', ClinicController::class);
Route::resource('procedures', ProcedureController::class);
Route::resource('bookings', BookingController::class);
Route::resource('reminders', ReminderController::class)
    ->only(['index', 'create', 'store']);




Route::patch('/bookings/{booking}/status/{status}', [BookingController::class, 'updateStatus'])
    ->name('bookings.status');

Route::post('/bookings/{booking}/status/{status}', [BookingController::class, 'setStatus'])
    ->name('bookings.setStatus');

Route::get('/reminders/dashboard', [ReminderController::class, 'dashboard'])->name('reminders.dashboard');
Route::post('/reminders/bulk', [ReminderController::class, 'bulkStore'])->name('reminders.bulk');
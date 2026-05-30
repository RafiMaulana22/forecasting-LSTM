<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ForecastingController;
use App\Http\Controllers\Admin\PendapatanController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['guest'])->group(function () {
    // Login Routes
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginProses'])->name('login.proses');
});

Route::middleware(['auth'])->group(function () {
    // Logout Route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Admin Pendapatan Route
    Route::resource('pendapatan', PendapatanController::class);

    // Admin Forecast Route
    Route::get('/forecasting', [ForecastingController::class, 'index'])->name('forecasting.index');
    Route::post('/forecasting/train', [ForecastingController::class, 'train'])->name('forecasting.train');
    Route::post('/forecasting/predict', [ForecastingController::class, 'predict'])->name('forecasting.predict');
});

<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DetailForecastingController;
use App\Http\Controllers\Admin\ForecastingController;
use App\Http\Controllers\Admin\HasilPrediksiController;
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
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Admin Pendapatan Route
    Route::resource('pendapatan', PendapatanController::class);
    Route::post('/pendapatan/import', [PendapatanController::class, 'import'])->name('pendapatan.import');

    // Admin Forecast Route
    Route::get('/forecasting', [ForecastingController::class, 'index'])->name('forecasting.index');
    Route::post('/forecasting/train', [ForecastingController::class, 'train'])->name('forecasting.train');
    Route::post('/forecasting/predict', [ForecastingController::class, 'predict'])->name('forecasting.predict');

    // Admin Hasil Prediksi Route
    Route::get('/hasil-prediksi', [HasilPrediksiController::class, 'index'])->name('hasil-prediksi.index');

    // Admin Detail Forecasting Route
    Route::get('/detail-forecasting', [DetailForecastingController::class, 'index'])->name('detail-forecasting.index');
    Route::get('/detail-forecasting/normalisasi', [DetailForecastingController::class, 'normalisasi'])->name('detail-forecasting.normalisasi');
    Route::get('/detail-forecasting/dataset', [DetailForecastingController::class, 'dataset'])->name('detail-forecasting.dataset');
    Route::get('/detail-forecasting/sequence', [DetailForecastingController::class, 'sequence'])->name('detail-forecasting.sequence');
    Route::get('/detail-forecasting/arsitektur', [DetailForecastingController::class, 'arsitektur'])->name('detail-forecasting.arsitektur');
    Route::get('/detail-forecasting/training', [DetailForecastingController::class, 'training'])->name('detail-forecasting.training');
    Route::get('/detail-forecasting/hasil-training', [DetailForecastingController::class, 'hasilTraining'])->name('detail-forecasting.hasil-training');
    Route::get('/detail-forecasting/testing', [DetailForecastingController::class, 'testing'])->name('detail-forecasting.testing');
    Route::get('/detail-forecasting/evaluasi', [DetailForecastingController::class, 'evaluasi'])->name('detail-forecasting.evaluasi');
    Route::get('/detail-forecasting/forecast', [DetailForecastingController::class, 'forecast'])->name('detail-forecasting.forecast');
});

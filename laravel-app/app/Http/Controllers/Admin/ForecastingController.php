<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Forecasting;
use App\Models\Pendapatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ForecastingController extends Controller
{
    public function index()
    {
        $forecastings = Forecasting::latest()->get();

        $labels = $forecastings->pluck('tanggal_prediksi');

        $data = $forecastings->pluck('hasil_prediksi');

        // dummy evaluasi sementara
        $mae = 0.12;
        $rmse = 0.2;
        $mape = 5.1;

        return view('Admin.forecasting.index', compact('forecastings', 'labels', 'data', 'mae', 'rmse', 'mape'));
    }

    // TRAIN MODEL
    public function train()
    {
        $pendapatan = Pendapatan::orderBy('tanggal')->get(['pendapatan']);

        $response = Http::post('http://127.0.0.1:5000/train', [
            'pendapatan' => $pendapatan,
        ]);

        return back()->with('success', 'Training model berhasil');
    }

    // FORECAST
    public function predict()
    {
        $pendapatan = Pendapatan::orderBy('tanggal')->pluck('pendapatan')->map(fn($item) => (float) $item)->values()->toArray();

        $response = Http::post('http://127.0.0.1:5000/forecast', [
            'pendapatan' => $pendapatan,
        ]);

        $result = $response->json();

        if (!isset($result['forecast'])) {
            return back()->with('error', $result['message'] ?? 'Forecast gagal');
        }

        foreach ($result['forecast'] as $index => $value) {
            Forecasting::create([
                'tanggal_prediksi' => now()->addDays($index + 1),

                'hasil_prediksi' => $value,

                'model' => 'LSTM',
            ]);
        }

        return back()->with('success', 'Forecasting 7 hari berhasil');
    }
}

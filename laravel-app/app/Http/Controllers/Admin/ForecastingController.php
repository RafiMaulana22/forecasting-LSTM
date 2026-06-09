<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi;
use App\Models\Forecasting;
use App\Models\HasilPrediksi;
use App\Models\Pendapatan;
use App\Models\TestingPrediction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ForecastingController extends Controller
{
    public function index()
    {
        $forecastings = Forecasting::latest()->get();

        $totalData = Pendapatan::count();

        $tanggalAwal = Pendapatan::min('tanggal');

        $tanggalAkhir = Pendapatan::max('tanggal');

        // Grafik Evaluasi
        $labels = HasilPrediksi::orderBy('tanggal')->pluck('tanggal');

        $actualData = HasilPrediksi::orderBy('tanggal')->pluck('aktual');

        $prediksiData = HasilPrediksi::orderBy('tanggal')->pluck('prediksi');

        return view('Admin.forecasting.index', compact('forecastings', 'totalData', 'tanggalAwal', 'tanggalAkhir', 'labels', 'actualData', 'prediksiData'));
    }

    // TRAIN MODEL
    public function train()
    {
        $pendapatan = Pendapatan::orderBy('tanggal')->pluck('pendapatan')->toArray();

        $response = Http::timeout(300)->post('http://127.0.0.1:5000/train', [
            'pendapatan' => $pendapatan,
        ]);

        $result = $response->json();

        if (!$response->successful()) {
            return back()->with('error', 'Training gagal');
        }

        Evaluasi::create([
            'mae' => $result['mae'],
            'rmse' => $result['rmse'],
            'mape' => $result['mape'],
            'epoch' => $result['epoch'],
            'loss' => $result['loss'],
        ]);

        HasilPrediksi::truncate();

        foreach ($result['historical'] as $item) {
            HasilPrediksi::create([
                'tanggal' => $item['tanggal'],
                'aktual' => $item['aktual'],
                'prediksi' => $item['prediksi'],
            ]);
        }

        return back()->with('success', 'Training model berhasil');
    }

    // FORECAST
    public function predict()
    {
        // ==========================
        // TRAIN MODEL
        // ==========================

        try {
            $trainResponse = Http::timeout(300)->post('http://127.0.0.1:5000/train', [
                'pendapatan' => Pendapatan::orderBy('tanggal')->pluck('pendapatan')->toArray(),

                'tanggal' => Pendapatan::orderBy('tanggal')->pluck('tanggal')->toArray(),
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        if (!$trainResponse->successful()) {
            return back()->with('error', 'Training model gagal');
        }

        $trainResult = $trainResponse->json();

        // dd($trainResult);

        // ==========================
        // SIMPAN EVALUASI
        // ==========================

        Evaluasi::create([
            'mae' => $trainResult['mae'],
            'rmse' => $trainResult['rmse'],
            'mape' => $trainResult['mape'],
            'epoch' => $trainResult['epoch'],
            'loss' => $trainResult['loss'],
            'loss_history' => json_encode($trainResult['loss_history']),
        ]);

        // ==========================
        // SIMPAN HISTORICAL PREDICTION
        // ==========================

        HasilPrediksi::truncate();

        TestingPrediction::truncate();

        if (isset($trainResult['testing'])) {
            foreach ($trainResult['testing'] as $item) {
                TestingPrediction::create([
                    'aktual' => $item['aktual'],

                    'prediksi' => $item['prediksi'],

                    'selisih' => $item['selisih'],
                ]);
            }
        }

        if (isset($trainResult['historical'])) {
            foreach ($trainResult['historical'] as $item) {
                HasilPrediksi::create([
                    'tanggal' => Carbon::parse($item['tanggal'])->format('Y-m-d'),

                    'aktual' => $item['aktual'],

                    'prediksi' => $item['prediksi'],
                ]);
            }
        }

        // ==========================
        // FORECAST 7 HARI
        // ==========================

        $response = Http::timeout(300)->post('http://127.0.0.1:5000/forecast', [
            'pendapatan' => Pendapatan::orderBy('tanggal')->pluck('pendapatan')->map(fn($item) => (float) $item)->values()->toArray(),
        ]);

        $result = $response->json();

        if (!isset($result['forecast'])) {
            return back()->with('error', $result['message'] ?? 'Forecast gagal');
        }

        Forecasting::truncate();

        $lastDate = Pendapatan::max('tanggal');

        foreach ($result['forecast'] as $index => $value) {
            Forecasting::create([
                'tanggal_prediksi' => \Carbon\Carbon::parse($lastDate)->addDays($index + 1),

                'hasil_prediksi' => $value,

                'model' => 'LSTM',
            ]);
        }

        return back()->with('success', 'Forecasting berhasil');
    }
}

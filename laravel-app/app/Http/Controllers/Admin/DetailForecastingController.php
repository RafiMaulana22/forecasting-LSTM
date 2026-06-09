<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi;
use App\Models\Forecasting;
use App\Models\Pendapatan;
use App\Models\TestingPrediction;
use Illuminate\Http\Request;

class DetailForecastingController extends Controller
{
    public function index()
    {
        return view('Admin.detailForecasting.index');
    }

    public function normalisasi()
    {
        $data = Pendapatan::orderBy('tanggal')->get();

        $min = $data->min('pendapatan');
        $max = $data->max('pendapatan');

        $normalisasi = $data->map(function ($item) use ($min, $max) {
            $nilaiNormalisasi = ($item->pendapatan - $min) / ($max - $min);

            return [
                'tanggal' => $item->tanggal,
                'aktual' => $item->pendapatan,
                'normalisasi' => round($nilaiNormalisasi, 6),
            ];
        });

        return view('Admin.detailForecasting.normalisasi', compact('normalisasi', 'min', 'max'));
    }

    public function dataset()
    {
        $totalData = Pendapatan::count();

        $trainSize = floor($totalData * 0.8);

        $testSize = $totalData - $trainSize;

        return view('Admin.detailForecasting.dataset', compact('totalData', 'trainSize', 'testSize'));
    }

    public function sequence()
    {
        $data = Pendapatan::orderBy('tanggal')->get();

        $totalData = $data->count();

        $trainSize = floor($totalData * 0.8);
        $testSize = $totalData - $trainSize;

        $timestep = 7;

        $totalTrainSequence = max(0, $trainSize - $timestep);
        $totalTestSequence = max(0, $testSize - $timestep);

        // Normalisasi
        $min = $data->min('pendapatan');
        $max = $data->max('pendapatan');

        $normalized = $data
            ->map(function ($item) use ($min, $max) {
                return round(($item->pendapatan - $min) / ($max - $min), 6);
            })
            ->values()
            ->toArray();

        // Ambil beberapa sequence pertama
        $sequenceExample = [];

        $trainData = $data->take($trainSize)->values();

        $testData = $data->slice($trainSize)->values();

        $trainSequence = [];

        for ($i = $timestep; $i < $trainData->count(); $i++) {
            $input = [];

            for ($j = $i - $timestep; $j < $i; $j++) {
                $nilai = ($trainData[$j]->pendapatan - $min) / ($max - $min);

                $input[] = [
                    'tanggal' => $trainData[$j]->tanggal,
                    'nilai' => round($nilai, 6),
                ];
            }

            $targetNilai = ($trainData[$i]->pendapatan - $min) / ($max - $min);

            $trainSequence[] = [
                'sequence_ke' => $i - $timestep + 1,
                'input' => $input,
                'target_tanggal' => $trainData[$i]->tanggal,
                'target' => round($targetNilai, 6),
            ];
        }

        $testSequence = [];

        for ($i = $timestep; $i < $testData->count(); $i++) {
            $input = [];

            for ($j = $i - $timestep; $j < $i; $j++) {
                $nilai = ($testData[$j]->pendapatan - $min) / ($max - $min);

                $input[] = [
                    'tanggal' => $testData[$j]->tanggal,
                    'nilai' => round($nilai, 6),
                ];
            }

            $targetNilai = ($testData[$i]->pendapatan - $min) / ($max - $min);

            $testSequence[] = [
                'sequence_ke' => $i - $timestep + 1,
                'input' => $input,
                'target_tanggal' => $testData[$i]->tanggal,
                'target' => round($targetNilai, 6),
            ];
        }

        return view('Admin.detailForecasting.sequence', compact('timestep', 'trainSize', 'testSize', 'totalTrainSequence', 'totalTestSequence', 'trainSequence', 'testSequence'));
    }

    public function arsitektur()
    {
        $arsitektur = [
            'timestep' => 7,
            'fitur' => 1,
            'lstm_neuron' => 50,
            'dense_neuron' => 1,
            'optimizer' => 'Adam',
            'loss' => 'Mean Squared Error (MSE)',
            'epoch' => 20,
            'batch_size' => 1,
        ];

        return view('Admin.detailForecasting.arsitektur', compact('arsitektur'));
    }

    public function training()
    {
        $totalData = Pendapatan::count();

        $trainSize = floor($totalData * 0.8);

        $timestep = 7;

        $totalTrainSequence = $trainSize - $timestep;

        $trainingConfig = [
            'epoch' => 20,
            'batch_size' => 1,
            'optimizer' => 'Adam',
            'loss_function' => 'Mean Squared Error (MSE)',
            'lstm_units' => 50,
            'dense_units' => 1,
        ];

        return view('Admin.detailForecasting.training', compact('trainSize', 'totalTrainSequence', 'trainingConfig'));
    }

    public function hasilTraining()
    {
        $evaluasi = Evaluasi::latest()->first();

        $lossHistory = [];

        if ($evaluasi && !empty($evaluasi->loss_history)) {
            $lossHistory = json_decode($evaluasi->loss_history, true) ?? [];
        }

        return view('Admin.detailForecasting.hasil-training', compact('evaluasi', 'lossHistory'));
    }

    public function testing()
    {
        $testingData = TestingPrediction::all();

        return view('Admin.detailForecasting.testing', compact('testingData'));
    }

    public function evaluasi()
    {
        $evaluasi = Evaluasi::latest()->first();

        return view('Admin.detailForecasting.evaluasi', compact('evaluasi'));
    }

    public function forecast()
    {
        $forecasts = Forecasting::orderBy('tanggal_prediksi')->get();

        $totalForecast = $forecasts->count();

        $rataRataForecast = $forecasts->avg('hasil_prediksi');

        $nilaiTertinggi = $forecasts->max('hasil_prediksi');

        $nilaiTerendah = $forecasts->min('hasil_prediksi');

        return view('Admin.detailForecasting.forecast', compact('forecasts', 'totalForecast', 'rataRataForecast', 'nilaiTertinggi', 'nilaiTerendah'));
    }
}

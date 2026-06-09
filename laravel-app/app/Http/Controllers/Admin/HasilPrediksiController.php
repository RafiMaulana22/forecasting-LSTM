<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi;
use App\Models\Forecasting;
use Illuminate\Http\Request;

class HasilPrediksiController extends Controller
{
    public function index()
    {
        $forecastings = Forecasting::latest()->orderBy('tanggal_prediksi')->get();
        $evaluasi = Evaluasi::latest()->first();

        return view('Admin.hasilPrediksi.index', compact('forecastings', 'evaluasi'));
    }
}

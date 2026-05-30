<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Forecasting;
use App\Models\Pendapatan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPendapatan = Pendapatan::sum('pendapatan');

        $totalData = Pendapatan::count();

        $pendapatanHariIni = Pendapatan::whereDate('tanggal', now())->sum('pendapatan');

        $chart = Pendapatan::orderBy('tanggal')->get();

        $labels = $chart->pluck('tanggal');

        $data = $chart->pluck('pendapatan');

        $forecasting = Forecasting::latest()->take(7)->get();

        return view('Admin.dashboard.index', compact('totalPendapatan', 'totalData', 'pendapatanHariIni', 'labels', 'data', 'forecasting'));
    }
}

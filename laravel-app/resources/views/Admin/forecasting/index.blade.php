@extends('layouts.app')

@section('content')
    {{-- BUTTON --}}
    <div class="card shadow mb-4">

        <div class="card-body">

            <div class="d-flex gap-2">

                {{-- TRAIN --}}
                <form action="/forecasting/train" method="POST">

                    @csrf

                    <button class="btn btn-primary">

                        Training Model

                    </button>

                </form>

                {{-- FORECAST --}}
                <form action="/forecasting/predict" method="POST">

                    @csrf

                    <button class="btn btn-success">

                        Forecasting

                    </button>

                </form>

            </div>

        </div>

    </div>

    {{-- ALERT --}}
    @if (session('success'))
        <div class="alert alert-success">

            {{ session('success') }}

        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">

            {{ session('error') }}

        </div>
    @endif

    {{-- EVALUASI --}}
    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card shadow border-0">

                <div class="card-body">

                    <h6>MAE</h6>

                    <h3>{{ $mae }}</h3>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow border-0">

                <div class="card-body">

                    <h6>RMSE</h6>

                    <h3>{{ $rmse }}</h3>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow border-0">

                <div class="card-body">

                    <h6>MAPE</h6>

                    <h3>{{ $mape }}%</h3>

                </div>

            </div>

        </div>

    </div>

    {{-- CHART --}}
    <div class="card shadow mb-4">

        <div class="card-body">

            <h5 class="mb-4">

                Grafik Forecasting

            </h5>

            <canvas id="forecastChart"></canvas>

        </div>

    </div>

    {{-- TABLE --}}
    <div class="card shadow">

        <div class="card-body">

            <h5 class="mb-4">

                Hasil Forecasting

            </h5>

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>No</th>
                        <th>Tanggal Prediksi</th>
                        <th>Hasil Forecasting</th>
                        <th>Model</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($forecastings as $item)
                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $item->tanggal_prediksi }}
                            </td>

                            <td>
                                Rp {{ number_format($item->hasil_prediksi, 0, ',', '.') }}
                            </td>

                            <td>
                                {{ $item->model }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4" class="text-center">

                                Belum ada forecasting

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- CHART JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('forecastChart');

        new Chart(ctx, {

            type: 'line',

            data: {

                labels: @json($labels),

                datasets: [{

                    label: 'Forecasting',

                    data: @json($data),

                    borderWidth: 2,

                    tension: 0.3

                }]

            }

        });
    </script>
@endsection

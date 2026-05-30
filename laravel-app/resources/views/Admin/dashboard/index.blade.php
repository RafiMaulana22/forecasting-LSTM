@extends('layouts.app')

@section('content')
    <div class="row">

        {{-- TOTAL DATA --}}
        <div class="col-md-4 mb-4">

            <div class="card shadow border-0">

                <div class="card-body">

                    <h6>Total Data</h6>

                    <h3>
                        {{ $totalData }}
                    </h3>

                </div>

            </div>

        </div>

        {{-- TOTAL PENDAPATAN --}}
        <div class="col-md-4 mb-4">

            <div class="card shadow border-0">

                <div class="card-body">

                    <h6>Total Pendapatan</h6>

                    <h3>
                        Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                    </h3>

                </div>

            </div>

        </div>

        {{-- HARI INI --}}
        <div class="col-md-4 mb-4">

            <div class="card shadow border-0">

                <div class="card-body">

                    <h6>Pendapatan Hari Ini</h6>

                    <h3>
                        Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}
                    </h3>

                </div>

            </div>

        </div>

    </div>

    {{-- CHART --}}
    <div class="card shadow border-0 mb-4">

        <div class="card-body">

            <h5 class="mb-4">
                Grafik Pendapatan
            </h5>

            <canvas id="chartPendapatan"></canvas>

        </div>

    </div>

    {{-- FORECASTING --}}
    <div class="card shadow border-0">

        <div class="card-body">

            <h5 class="mb-4">
                Forecasting Terbaru
            </h5>

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Hasil Prediksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($forecasting as $item)
                        <tr>

                            <td>
                                {{ $item->tanggal_prediksi }}
                            </td>

                            <td>
                                Rp {{ number_format($item->hasil_prediksi, 0, ',', '.') }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="2" class="text-center">
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
        const ctx = document.getElementById('chartPendapatan');

        new Chart(ctx, {

            type: 'line',

            data: {

                labels: @json($labels),

                datasets: [{
                    label: 'Pendapatan',

                    data: @json($data),

                    borderWidth: 2,

                    tension: 0.3
                }]
            }

        });
    </script>
@endsection

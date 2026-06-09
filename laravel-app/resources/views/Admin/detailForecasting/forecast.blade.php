@extends('layouts.app')

@section('title', 'Forecast 7 Hari Ke Depan')

@section('content')
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">Forecast 7 Hari Ke Depan</h1>
                <p class="text-xs text-slate-400 mt-0.5">Hasil komputasi final proyeksi nilai nominal omzet pendapatan warung
                    untuk horizon target masa depan</p>
            </div>
            <a href="{{ route('detail-forecasting.index') }}"
                class="inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-900 text-white px-4 py-2.5 rounded-xl text-xs font-bold transition-colors no-underline border-0 cursor-pointer shrink-0">
                <i class="bi bi-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center text-xl shrink-0 border border-blue-100/30">
                    <i class="bi bi-calendar-range"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight leading-tight">{{ $totalForecast }}
                        Hari</h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Horizon Target</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl shrink-0 border border-emerald-100/30">
                    <i class="bi bi-graph-up"></i>
                </div>
                <div>
                    <h3 class="text-xl font-extrabold text-emerald-600 tracking-tight leading-tight">
                        Rp {{ number_format($rataRataForecast, 0, ',', '.') }}
                    </h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Rata-rata Prediksi</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-purple-50 text-purple-500 flex items-center justify-center text-xl shrink-0 border border-purple-100/30">
                    <i class="bi bi-arrow-up-right-circle"></i>
                </div>
                <div>
                    <h3 class="text-xl font-extrabold text-slate-800 tracking-tight leading-tight">
                        Rp {{ number_format($nilaiTertinggi, 0, ',', '.') }}
                    </h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Prediksi Tertinggi</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-xl shrink-0 border border-amber-100/30">
                    <i class="bi bi-arrow-down-left-circle"></i>
                </div>
                <div>
                    <h3 class="text-xl font-extrabold text-slate-800 tracking-tight leading-tight">
                        Rp {{ number_format($nilaiTerendah, 0, ',', '.') }}
                    </h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Prediksi Terendah</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h4 class="text-base font-bold text-slate-800">Visualisasi Tren Forecast</h4>
                    <p class="text-xs text-slate-400 mt-0.5">Alur pergerakan naik-turun akumulasi finansial warung hasil
                        ramalan memori jangka pendek LSTM</p>
                </div>
                <div class="flex items-center gap-2 bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-100">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Garis Estimasi</span>
                </div>
            </div>
            <div class="relative h-72 w-full">
                <canvas id="forecastChart"></canvas>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <div class="mb-4">
                    <h4 class="text-sm font-bold text-slate-800">Tabel Rincian Hasil Peramalan</h4>
                    <p class="text-[11px] text-slate-400 mt-0.5">Breakdown data kuantitatif nilai prediksi per tanggal
                        target</p>
                </div>

                <div class="overflow-x-auto rounded-xl border border-slate-100">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr
                                class="bg-slate-50 border-b border-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider">
                                <th class="px-6 py-3.5 text-center w-20">No</th>
                                <th class="px-6 py-3.5">Tanggal Target Esok</th>
                                <th class="px-6 py-3.5 text-right pr-12">Nominal Proyeksi Penjualan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-600 font-medium">
                            @foreach ($forecasts as $item)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 text-center font-bold text-slate-400 bg-slate-50/20">
                                        {{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 font-semibold text-slate-700">
                                        {{ \Carbon\Carbon::parse($item->tanggal_prediksi)->translatedFormat('d F Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-right pr-12 font-bold text-emerald-600 text-sm">
                                        Rp {{ number_format($item->hasil_prediksi, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-between">
                <div class="space-y-4">
                    <h4 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i class="bi bi-lightbulb text-amber-500"></i> Rekomendasi Strategi Toko
                    </h4>
                    <div class="text-xs text-slate-500 leading-relaxed space-y-3 font-medium">
                        <p>
                            Kalkulasi sistem peramalan melacak pola konsumsi berkala dari data masa lalu eceran grosir.
                            Model mendeteksi fluktuasi perputaran kasir untuk memetakan estimasi 7 hari kedepan.
                        </p>
                        <p>
                            Luaran data ini bertindak sebagai bahan rujukan krusial bagi manajemen internal Warung Madura
                            dalam menentukan kuantitas pembelanjaan unit sembako utama (beras, minyak goreng, telur) sebelum
                            titik lonjakan hari ramai terjadi.
                        </p>
                    </div>
                </div>

                <div
                    class="mt-6 p-3 bg-emerald-50/50 border border-emerald-100/50 rounded-xl text-[11px] text-emerald-800 flex gap-2.5 items-start">
                    <i class="bi bi-shield-check-fill text-emerald-500 text-sm mt-0.5 shrink-0"></i>
                    <span class="leading-relaxed">Gunakan titik capaian <b>Nilai Tertinggi</b> sebagai acuan batas aman
                        modal penambahan volume restok barang borongan grosir toko.</span>
                </div>
            </div>

        </div>

    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('forecastChart').getContext('2d');

            // Mapping array label tanggal dari perulangan blade secara langsung
            const labels = [
                @foreach ($forecasts as $item)
                    '{{ \Carbon\Carbon::parse($item->tanggal_prediksi)->translatedFormat('d/m') }}',
                @endforeach
            ];

            // Mapping array nilai data nominal dari perulangan blade secara langsung
            const dataValues = [
                @foreach ($forecasts as $item)
                    {{ $item->hasil_prediksi }},
                @endforeach
            ];

            // Efek gradien hijau bersinar transparan di bawah garis chart proyeksi
            const gradient = ctx.createLinearGradient(0, 0, 0, 260);
            gradient.addColorStop(0, 'rgba(16, 185, 129, 0.18)');
            gradient.addColorStop(1, 'rgba(16, 185, 129, 0.00)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Forecast Pendapatan',
                        data: dataValues,
                        borderColor: '#10b981',
                        borderWidth: 3,
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.38,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#10b981',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            grid: {
                                color: '#f1f5f9'
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: {
                                    size: 11
                                },
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection

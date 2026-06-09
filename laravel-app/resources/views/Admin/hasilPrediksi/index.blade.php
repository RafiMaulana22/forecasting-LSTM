@extends('layouts.app')

@section('title', 'Hasil Prediksi')

@section('content')
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">Hasil Prediksi Pendapatan</h1>
                <p class="text-xs text-slate-400 mt-0.5">Daftar keluaran nilai proyeksi omzet harian hasil kalkulasi
                    arsitektur LSTM</p>
            </div>
            <form action="{{ route('forecasting.predict') }}" method="POST" class="inline">
                @csrf
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-xl text-xs font-bold shadow-md shadow-emerald-900/10 transition-all duration-150 cursor-pointer border-0">
                    <i class="bi bi-graph-up-arrow text-xs"></i>
                    <span>Jalankan Prediksi</span>
                </button>
            </form>
        </div>

        @if (session('success'))
            <div class="flex items-center gap-2.5 p-4 text-xs font-semibold text-emerald-800 border border-emerald-100 rounded-xl bg-emerald-50"
                role="alert">
                <i class="bi bi-check-circle-fill text-emerald-500 text-sm"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if (session('error'))
            <div class="flex items-center gap-2.5 p-4 text-xs font-semibold text-rose-800 border border-rose-100 rounded-xl bg-rose-50"
                role="alert">
                <i class="bi bi-exclamation-triangle-fill text-rose-500 text-sm"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center text-xl shrink-0 border border-blue-100/30">
                    <i class="bi bi-list-check"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight leading-tight">
                        {{ $forecastings->count() }}</h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Total Hari Terprediksi
                    </p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl shrink-0 border border-emerald-100/30">
                    <i class="bi bi-cpu"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight leading-tight">LSTM</h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Arsitektur Model Inti
                    </p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-xl shrink-0 border border-amber-100/30">
                    <i class="bi bi-calendar-range"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight leading-tight">7 Hari</h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Rentang Jarak Horizon
                    </p>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-5">

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
                <p class="text-xs font-bold text-slate-400 uppercase">MAE</p>
                <h3 class="text-xl font-extrabold text-slate-800 mt-2">
                    Rp {{ number_format($evaluasi->mae ?? 0, 0, ',', '.') }}
                </h3>
                <p class="text-[11px] text-slate-400 mt-1">
                    Rata-rata error prediksi
                </p>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
                <p class="text-xs font-bold text-slate-400 uppercase">RMSE</p>
                <h3 class="text-xl font-extrabold text-slate-800 mt-2">
                    Rp {{ number_format($evaluasi->rmse ?? 0, 0, ',', '.') }}
                </h3>
                <p class="text-[11px] text-slate-400 mt-1">
                    Root Mean Squared Error
                </p>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
                <p class="text-xs font-bold text-slate-400 uppercase">MAPE</p>
                <h3 class="text-2xl font-extrabold text-emerald-600 mt-2">
                    {{ number_format($evaluasi->mape ?? 0, 2) }}%
                </h3>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
                <p class="text-xs font-bold text-slate-400 uppercase">Epoch</p>
                <h3 class="text-2xl font-extrabold text-slate-800 mt-2">
                    {{ $evaluasi->epoch ?? 20 }}
                </h3>
            </div>

        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h4 class="text-base font-bold text-slate-800">Grafik Prediksi Pendapatan</h4>
                    <p class="text-xs text-slate-400 mt-0.5">Visualisasi alur naik-turun hasil ramalan nominal omzet toko
                    </p>
                </div>
                <div class="flex items-center gap-2 bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-100">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Garis Proyeksi</span>
                </div>
            </div>
            <div class="relative h-72 w-full">
                <canvas id="forecastChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="mb-4">
                <h4 class="text-base font-bold text-slate-800">Data Hasil Prediksi</h4>
                <p class="text-xs text-slate-400 mt-0.5">Rincian angka kuantitatif hasil forecasting per tanggal</p>
            </div>

            <div class="overflow-x-auto rounded-xl border border-slate-100">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-50 border-b border-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider">
                            <th class="px-6 py-4 text-center w-20">No</th>
                            <th class="px-6 py-4">Tanggal Target Prediksi</th>
                            <th class="px-6 py-4">Nominal Estimasi Hasil</th>
                            <th class="px-6 py-4 w-44">Identifikasi Model</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                        @forelse($forecastings as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-center font-bold text-slate-400">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 font-semibold text-slate-700">
                                    {{ \Carbon\Carbon::parse($item->tanggal_prediksi)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold text-emerald-600 text-sm">
                                        Rp {{ number_format($item->hasil_prediksi, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase tracking-wider border border-emerald-100/50">
                                        {{ $item->model }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-12">
                                    <div
                                        class="w-11 h-11 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 mx-auto mb-3 text-lg border border-slate-100">
                                        <i class="bi bi-graph-up-arrow"></i>
                                    </div>
                                    <p class="text-xs text-slate-400 font-medium">Data luaran hasil prediksi belum
                                        digenerate.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Mengambil kumpulan nilai array model Eloquent Collection langsung via pluck blade
            const rawLabels = @json($forecastings->pluck('tanggal_prediksi'));
            const dataValues = @json($forecastings->pluck('hasil_prediksi'));

            const ctx = document.getElementById('forecastChart').getContext('2d');

            // Merapikan format string mentah dari database menjadi format ringkas "01 Jun"
            const formattedLabels = rawLabels.map(label => {
                const date = new Date(label);
                return isNaN(date) ? label : date.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'short'
                });
            });

            // Membuat gradien halus hijau di bawah area garis chart
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(16, 185, 129, 0.18)');
            gradient.addColorStop(1, 'rgba(16, 185, 129, 0.00)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: formattedLabels,
                    datasets: [{
                        label: 'Proyeksi Omzet',
                        data: dataValues,
                        borderColor: '#10b981',
                        borderWidth: 3,
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.36,
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

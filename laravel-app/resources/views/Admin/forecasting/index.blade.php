@extends('layouts.app')

@section('title', 'Forecasting')

@section('content')
    <div class="space-y-6">

        <div
            class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">Forecasting Pendapatan</h1>
                <p class="text-xs text-slate-400 mt-0.5">Sistem akan melakukan preprocessing data, pelatihan model LSTM, dan
                    prediksi pendapatan secara otomatis.</p>
            </div>
            <div class="flex gap-2">

                <form action="{{ route('forecasting.predict') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-xs font-bold">
                        <i class="bi bi-play-circle"></i>
                        Jalankan Forecasting
                    </button>
                </form>

                <a href="{{ route('detail-forecasting.index') }}"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-xs font-bold">
                    <i class="bi bi-journal-text"></i>
                    Detail Proses Forecasting
                </a>

            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
                <p class="text-xs text-slate-400">Jumlah Dataset</p>
                <h3 class="text-2xl font-bold text-slate-800">
                    {{ $totalData }}
                </h3>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
                <p class="text-xs text-slate-400">Tanggal Awal</p>
                <h3 class="text-lg font-bold text-slate-800">
                    {{ \Carbon\Carbon::parse($tanggalAwal)->format('d M Y') }}
                </h3>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
                <p class="text-xs text-slate-400">Tanggal Akhir</p>
                <h3 class="text-lg font-bold text-slate-800">
                    {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d M Y') }}
                </h3>
            </div>

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

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <h4 class="text-sm font-bold text-slate-800 mb-5 flex items-center gap-2">
                <i class="bi bi-bezier2 text-emerald-600"></i> Alur Pemrosesan Model Data
            </h4>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-100 flex items-center gap-4">
                    <div
                        class="w-11 h-11 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center text-xl shrink-0 border border-blue-100/30">
                        <i class="bi bi-database"></i>
                    </div>
                    <div>
                        <h6 class="text-xs font-bold text-slate-700">Data Historis</h6>
                        <p class="text-[11px] text-slate-400 mt-0.5 leading-tight">Pengumpulan basis data transaksi.</p>
                    </div>
                </div>

                <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-100 flex items-center gap-4">
                    <div
                        class="w-11 h-11 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-xl shrink-0 border border-amber-100/30">
                        <i class="bi bi-filter-circle"></i>
                    </div>
                    <div>
                        <h6 class="text-xs font-bold text-slate-700">Preprocessing</h6>
                        <p class="text-[11px] text-slate-400 mt-0.5 leading-tight">Normalisasi nilai & scaling skewness.</p>
                    </div>
                </div>

                <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-100 flex items-center gap-4">
                    <div
                        class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl shrink-0 border border-emerald-100/30">
                        <i class="bi bi-cpu"></i>
                    </div>
                    <div>
                        <h6 class="text-xs font-bold text-slate-700">Model LSTM</h6>
                        <p class="text-[11px] text-slate-400 mt-0.5 leading-tight">Pelatihan arsitektur neural network.</p>
                    </div>
                </div>

                <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-100 flex items-center gap-4">
                    <div
                        class="w-11 h-11 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center text-xl shrink-0 border border-rose-100/30">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <div>
                        <h6 class="text-xs font-bold text-slate-700">Forecasting</h6>
                        <p class="text-[11px] text-slate-400 mt-0.5 leading-tight">Output prediksi 7 hari ke depan.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="mb-4">
                <h4 class="text-base font-bold text-slate-800">Grafik Data Aktual dan Forecasting Pendapatan</h4>
                <p class="text-xs text-slate-400 mt-0.5">Menampilkan perbandingan data historis pendapatan dengan hasil
                    prediksi 7 hari ke depan menggunakan metode LSTM.</p>
            </div>
            <div class="relative h-72 w-full">
                <canvas id="forecastChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="mb-4">
                <h4 class="text-base font-bold text-slate-800">Tabel Rincian Hasil Peramalan</h4>
                <p class="text-xs text-slate-400 mt-0.5">Log data kalkulasi nominal prediksi yang disimpan ke dalam sistem
                    database</p>
            </div>

            <div class="mb-4 p-4 rounded-xl bg-emerald-50 border border-emerald-100">

                <h5 class="font-semibold text-emerald-700">
                    Informasi Forecasting
                </h5>

                <p class="text-xs text-emerald-600 mt-1">
                    Sistem menggunakan {{ $totalData }}
                    data historis pendapatan dari
                    {{ \Carbon\Carbon::parse($tanggalAwal)->format('d M Y') }}
                    sampai
                    {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d M Y') }}
                    untuk menghasilkan prediksi pendapatan
                    selama 7 hari ke depan.
                </p>

            </div>

            <div class="overflow-x-auto rounded-xl border border-slate-100">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-50 border-b border-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider">
                            <th class="px-6 py-4 text-center w-20">No</th>
                            <th class="px-6 py-4">Tanggal Prediksi</th>
                            <th class="px-6 py-4">Hasil Kalkulasi Forecasting</th>
                            <th class="px-6 py-4 w-40">Arsitektur Model</th>
                            <th class="px-6 py-4 w-28 text-center">Status</th>
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
                                        class="inline-flex items-center px-2 py-0.5 rounded bg-slate-100 text-slate-700 text-[10px] font-bold uppercase tracking-wider border border-slate-200/50">
                                        {{ $item->model }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase tracking-wider border border-emerald-100/50">
                                        Selesai
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-12">
                                    <div
                                        class="w-11 h-11 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 mx-auto mb-3 text-lg border border-slate-100">
                                        <i class="bi bi-cpu"></i>
                                    </div>
                                    <p class="text-xs text-slate-400 font-medium">Belum ada riwayat perhitungan forecasting
                                        yang tersimpan.</p>
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
            const ctx = document.getElementById('forecastChart').getContext('2d');

            const rawLabels = @json($labels);

            const actualData = @json($actualData);

            const prediksiData = @json($prediksiData);

            const formattedLabels = rawLabels.map(label => {
                const date = new Date(label);
                return isNaN(date) ? label : date.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'short'
                });
            });

            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(16, 185, 129, 0.15)');
            gradient.addColorStop(1, 'rgba(16, 185, 129, 0.00)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: formattedLabels,
                    datasets: [

                        {
                            label: 'Data Aktual',
                            data: actualData,
                            borderColor: '#3b82f6',
                            backgroundColor: 'transparent',
                            borderWidth: 3,
                            tension: 0.3,
                            pointRadius: 2
                        },

                        {
                            label: 'Prediksi LSTM',
                            data: prediksiData,
                            borderColor: '#10b981',
                            backgroundColor: 'transparent',
                            borderDash: [5, 5],
                            borderWidth: 3,
                            tension: 0.3,
                            pointRadius: 2
                        }

                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
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

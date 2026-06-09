@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="space-y-6">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center text-xl shrink-0">
                    <i class="bi bi-database"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-slate-800 leading-tight">{{ $totalData }}</h3>
                    <p class="text-xs font-medium text-slate-400 mt-0.5">Total Histori Data</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl shrink-0">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800 leading-tight">Rp
                        {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                    <p class="text-xs font-medium text-slate-400 mt-0.5">Total Pendapatan</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-xl shrink-0">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <div>
                    <h3
                        class="text-xl font-bold {{ $pendapatanHariIni > 0 ? 'text-slate-800' : 'text-slate-400' }} leading-tight">
                        Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}
                    </h3>
                    <p class="text-xs font-medium text-slate-400 mt-0.5">Pendapatan Hari Ini</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-500 flex items-center justify-center text-xl shrink-0">
                    <i class="bi bi-cpu"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-slate-800 leading-tight">LSTM</h3>
                    <p class="text-xs font-medium text-slate-400 mt-0.5">Engine Model AI</p>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                <div class="mb-4">
                    <h4 class="text-base font-bold text-slate-800">Grafik Tren Pendapatan</h4>
                    <p class="text-xs text-slate-400 mt-0.5">Visualisasi data berkala histori transaksi omzet warung</p>
                </div>
                <div class="relative h-72 w-full">
                    <canvas id="chartPendapatan"></canvas>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-between">
                <div>
                    <h4 class="text-base font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <i class="bi bi-info-circle text-emerald-500"></i> Ringkasan Sistem
                    </h4>

                    <div class="space-y-4">
                        <div class="pb-3 border-b border-slate-100">
                            <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Metode
                                Arsitektur</span>
                            <span class="text-sm font-semibold text-slate-700 mt-0.5 block">Long Short Term Memory</span>
                        </div>
                        <div class="pb-3 border-b border-slate-100">
                            <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Forecast
                                Horizon</span>
                            <span class="text-sm font-bold text-emerald-600 mt-0.5 block">7 Hari ke Depan</span>
                        </div>
                        <div>
                            <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Kombinasi
                                Framework</span>
                            <div class="flex items-center gap-1.5 mt-1.5">
                                <span
                                    class="px-2 py-0.5 bg-rose-50 text-rose-600 rounded-md text-xs font-bold border border-rose-100">Laravel</span>
                                <span class="text-slate-300 text-xs">+</span>
                                <span
                                    class="px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded-md text-xs font-bold border border-emerald-100">Flask
                                    AI</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="mt-6 p-3 bg-slate-50 border border-slate-100 rounded-xl text-xs text-slate-500 flex gap-2.5 items-start">
                    <i class="bi bi-lightning-charge-fill text-amber-500 text-sm mt-0.5 shrink-0"></i>
                    <span class="leading-relaxed">Sistem cerdas mendeteksi pola data pembelian berulang untuk mematangkan
                        akurasi prediksi.</span>
                </div>
            </div>

        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h4 class="text-base font-bold text-slate-800">Forecasting Terbaru</h4>
                    <p class="text-xs text-slate-400 mt-0.5">Proyeksi nilai nominal pendapatan warung pada tanggal terdekat
                    </p>
                </div>
                <a href="/hasil-prediksi"
                    class="text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 px-4 py-2 rounded-xl shadow-md shadow-emerald-100/60 transition-colors no-underline">
                    Lihat Semua
                </a>
            </div>

            <div class="overflow-x-auto rounded-xl border border-slate-100">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-50 border-b border-slate-100 text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                            <th class="px-6 py-3.5">Tanggal</th>
                            <th class="px-6 py-3.5 text-right">Hasil Prediksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                        @forelse($forecasting as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-3.5 font-semibold text-slate-800">
                                    {{ \Carbon\Carbon::parse($item->tanggal_prediksi)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-3.5 text-right font-bold text-emerald-600">
                                    Rp {{ number_format($item->hasil_prediksi, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center py-12">
                                    <div
                                        class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 mx-auto mb-3 text-xl border border-slate-100">
                                        <i class="bi bi-graph-up"></i>
                                    </div>
                                    <p class="text-xs text-slate-400 font-medium">Belum ada riwayat data forecasting yang
                                        diproses.</p>
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
            const ctx = document.getElementById('chartPendapatan').getContext('2d');

            const rawLabels = @json($labels);
            const dataValues = @json($data);

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
                    datasets: [{
                        label: 'Pendapatan Toko',
                        data: dataValues,
                        borderColor: '#10b981',
                        borderWidth: 3,
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.35,
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

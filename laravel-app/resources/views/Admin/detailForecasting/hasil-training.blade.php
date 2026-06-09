@extends('layouts.app')

@section('title', 'Hasil Training Model')

@section('content')
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">Hasil Training Model</h1>
                <p class="text-xs text-slate-400 mt-0.5">Ringkasan hasil evaluasi performa model komputasi LSTM setelah
                    melewati batas epoch</p>
            </div>
            <a href="{{ route('detail-forecasting.index') }}"
                class="inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-900 text-white px-4 py-2.5 rounded-xl text-xs font-bold transition-colors no-underline border-0 cursor-pointer">
                <i class="bi bi-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center text-xl shrink-0 border border-blue-100/30">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight leading-tight">
                        {{ $evaluasi->epoch }}
                    </h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Total Epoch Berjalan</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl shrink-0 border border-emerald-100/30">
                    <i class="bi bi-graph-down"></i>
                </div>
                <div>
                    <h3 class="text-xl font-extrabold text-emerald-600 tracking-tight leading-tight font-mono">
                        {{ number_format($evaluasi->loss, 8, ',', '.') }}
                    </h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Nilai Final Loss Model
                    </p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-purple-50 text-purple-500 flex items-center justify-center text-xl shrink-0 border border-purple-100/30">
                    <i class="bi bi-check2-circle"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-purple-600 tracking-tight leading-tight">Selesai</h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Status Pelatihan</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h4 class="text-base font-bold text-slate-800">Grafik Konvergensi Loss</h4>
                    <p class="text-xs text-slate-400 mt-0.5">Visualisasi penurunan nilai error disetiap iterasi pembelajaran
                        model</p>
                </div>
                <div class="flex items-center gap-2 bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-100">
                    <span class="w-2.5 h-2.5 rounded-full bg-rose-500 animate-pulse"></span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Kurva MSE Loss</span>
                </div>
            </div>
            <div class="relative h-72 w-full">
                <canvas id="lossChart"></canvas>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-between">
                <div class="space-y-4">
                    <h4 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i class="bi bi-journal-text text-emerald-600"></i> Interpretasi Hasil Kelayakan
                    </h4>
                    <div class="text-xs text-slate-500 leading-relaxed space-y-3 font-medium">
                        <p>
                            Nilai loss akhir yang diperoleh sebesar <span
                                class="text-slate-800 font-mono font-bold">{{ number_format($evaluasi->loss, 8, ',', '.') }}</span>
                            menunjukkan kuantitas ambang batas margin kesalahan model selama proses pelatihan menggunakan
                            fungsi kriteria <b>Mean Squared Error (MSE)</b>.
                        </p>
                        <p>
                            Secara matematis, semakin mendekati angka nol parameter loss history yang dicapai,
                            mengidentifikasikan bahwa jaringan saraf tiruan LSTM telah optimal dan matang dalam menyerap
                            pola fluktuatif serta musiman dari riwayat omzet Warung Sembako Madura.
                        </p>
                    </div>
                </div>

                <div
                    class="mt-6 p-3 bg-slate-50 border border-slate-100 rounded-xl text-[11px] text-slate-500 flex gap-2.5 items-start">
                    <i class="bi bi-info-circle-fill text-blue-500 text-sm mt-0.5 shrink-0"></i>
                    <span class="leading-relaxed">Garis kurva yang melandai turun secara konisten tanpa lonjakan drastis
                        menandakan model terbebas dari kendala overfitting.</span>
                </div>
            </div>

            <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <div class="mb-4">
                    <h4 class="text-sm font-bold text-slate-800">Log Nilai Error Per-Epoch</h4>
                    <p class="text-[11px] text-slate-400 mt-0.5">Rincian data riwayat angka penyusutan fungsi loss disetiap
                        tingkatan epoch</p>
                </div>

                <div class="overflow-x-auto rounded-xl border border-slate-100 max-h-[295px] overflow-y-auto">
                    <table class="w-full text-left border-collapse">
                        <thead
                            class="sticky top-0 z-10 bg-slate-50 border-b border-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-3 text-center w-24">Urutan Epoch</th>
                                <th class="px-6 py-3">Nilai Tingkat Error Fungsi Loss (MSE)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                            @if (count($lossHistory) > 0)
                                @foreach ($lossHistory as $index => $loss)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-3 text-center font-bold text-slate-400 bg-slate-50/20">Epoch
                                            {{ $index + 1 }}</td>
                                        <td class="px-6 py-3 font-mono font-semibold text-rose-600 tracking-wide">
                                            {{ number_format($loss, 8, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="2" class="text-center py-12">
                                        <div
                                            class="w-11 h-11 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 mx-auto mb-2 text-lg border border-slate-100">
                                            <i class="bi bi-slash-circle"></i>
                                        </div>
                                        <p class="text-xs text-slate-400 font-medium">Data log urutan loss history belum
                                            terekam di sistem.</p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const lossData = @json($lossHistory);
            const ctx = document.getElementById('lossChart').getContext('2d');

            // Membuat efek gradien merah memudar di bawah garis kurva loss
            const gradient = ctx.createLinearGradient(0, 0, 0, 250);
            gradient.addColorStop(0, 'rgba(239, 68, 68, 0.15)');
            gradient.addColorStop(1, 'rgba(239, 68, 68, 0.00)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: lossData.map((_, i) => 'Epoch ' + (i + 1)),
                    datasets: [{
                        label: 'Nilai MSE Loss',
                        data: lossData,
                        borderColor: '#ef4444', // Menggunakan warna merah (rose-500) sebagai identifikasi fungsi loss/error
                        borderWidth: 3,
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#ef4444',
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


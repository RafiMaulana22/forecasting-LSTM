@extends('layouts.app')

@section('title', 'Evaluasi Model')

@section('content')
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">Evaluasi Performa Model</h1>
                <p class="text-xs text-slate-400 mt-0.5">Hasil validasi tingkat akurasi komputasi jaringan LSTM menggunakan
                    instrumen MAE, RMSE, dan MAPE</p>
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
                    class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shrink-0 border border-blue-100/30">
                    <i class="bi bi-arrow-left-right"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight leading-tight font-mono">
                        {{ number_format($evaluasi->mae, 4, ',', '.') }}
                    </h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Mean Absolute Error
                        (MAE)</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0 border border-emerald-100/30">
                    <i class="bi bi-activity"></i>
                </div>
                <div>
                    <h3 class="text-xl font-extrabold text-slate-800 tracking-tight leading-tight font-mono">
                        {{ number_format($evaluasi->rmse, 4, ',', '.') }}
                    </h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Root Mean Squared Error
                        (RMSE)</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl shrink-0 border border-purple-100/30">
                    <i class="bi bi-percent"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-purple-600 tracking-tight leading-tight font-mono">
                        {{ number_format($evaluasi->mape, 2, ',', '.') }}%
                    </h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Absolute Percentage
                        (MAPE)</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div
                class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-between">
                <div class="space-y-4">
                    <h4 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i class="bi bi-journal-text text-emerald-600"></i> Definisi Operasional Instrumen
                    </h4>
                    <div class="text-xs text-slate-500 leading-relaxed space-y-3 font-medium">
                        <p>
                            Nilai <b>MAE</b> merepresentasikan simpangan rata-rata kesalahan absolut antara nominal aktual
                            omzet asli dengan tebakan model. Nilai <b>RMSE</b> mengukur akar kuadrat kuantitas error untuk
                            memberi penalti bobot yang lebih besar terhadap deviasi ekstrem.
                        </p>
                        <p>
                            Sedangkan parameter <b>MAPE</b> mengonversi selisih margin kesalahan ke dalam bentuk nilai
                            persentase relatif terhadap data aktual. Hal ini memudahkan pemilik warung dalam membaca akurasi
                            model tanpa bias satuan nilai nominal rupiah.
                        </p>
                    </div>
                </div>

                <div
                    class="mt-6 flex items-center justify-between p-4 rounded-xl border transition-all duration-200
                @if ($evaluasi->mape < 10) bg-emerald-50/70 border-emerald-200 text-emerald-800
                @elseif ($evaluasi->mape < 20) bg-blue-50/70 border-blue-200 text-blue-800
                @elseif ($evaluasi->mape < 50) bg-amber-50/70 border-amber-200 text-amber-800
                @else bg-rose-50/70 border-rose-200 text-rose-800 @endif">

                    <div class="flex items-center gap-3">
                        <div class="text-xl shrink-0">
                            @if ($evaluasi->mape < 10)
                                <i class="bi bi-shield-check-fill text-emerald-500"></i>
                            @elseif ($evaluasi->mape < 20)
                                <i class="bi bi-check-circle-fill text-blue-500"></i>
                            @elseif ($evaluasi->mape < 50)
                                <i class="bi bi-exclamation-triangle-fill text-amber-500"></i>
                            @else
                                <i class="bi bi-x-circle-fill text-rose-500"></i>
                            @endif
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase font-bold tracking-wider opacity-60">Kesimpulan
                                Kelayakan</span>
                            <h5 class="text-sm font-black mt-0.5">
                                @if ($evaluasi->mape < 10)
                                    Kemampuan Akurasi Sangat Baik
                                @elseif ($evaluasi->mape < 20)
                                    Kemampuan Akurasi Baik
                                @elseif ($evaluasi->mape < 50)
                                    Kemampuan Akurasi Cukup Baik
                                @else
                                    Kemampuan Akurasi Kurang Baik
                                @endif
                            </h5>
                        </div>
                    </div>

                    <div
                        class="text-xs font-semibold px-3 py-1 bg-white/60 rounded-lg border border-white/40 shadow-sm font-mono">
                        MAPE: {{ number_format($evaluasi->mape, 2, ',', '.') }}%
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-between">
                <div>
                    <h4 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <i class="bi bi-list-columns-reverse text-emerald-600"></i> Ringkasan Matriks
                    </h4>

                    <div class="overflow-x-auto rounded-xl border border-slate-100">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr
                                    class="bg-slate-50 border-b border-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider">
                                    <th class="px-4 py-3">Metrik Pengujian</th>
                                    <th class="px-4 py-3 text-right pr-6">Nilai Log</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-600 font-semibold">
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-4 py-3.5 font-normal text-slate-500">Mean Absolute Error</td>
                                    <td class="px-4 py-3.5 text-right pr-6 font-mono font-bold text-slate-800">
                                        {{ number_format($evaluasi->mae, 4, ',', '.') }}</td>
                                </tr>
                                <tr class="bg-slate-50/30 hover:bg-slate-50/50 transition-colors">
                                    <td class="px-4 py-3.5 font-normal text-slate-500">Root Mean Squared Error</td>
                                    <td class="px-4 py-3.5 text-right pr-6 font-mono font-bold text-slate-800">
                                        {{ number_format($evaluasi->rmse, 4, ',', '.') }}</td>
                                </tr>
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-4 py-3.5 font-normal text-slate-500">Absolute Percentage Error</td>
                                    <td class="px-4 py-3.5 text-right pr-6 font-mono font-bold text-purple-600">
                                        {{ number_format($evaluasi->mape, 2, ',', '.') }}%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-4 text-[10px] text-slate-400 font-medium leading-relaxed">
                    * Kriteria penilaian batas persentase kelayakan mengacu pada standar industri peramalan internasional
                    Lewis (1982).
                </div>
            </div>

        </div>

    </div>
@endsection

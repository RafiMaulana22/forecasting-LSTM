@extends('layouts.app')

@section('title', 'Prediksi Data Testing')

@section('content')
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">Prediksi Data Testing</h1>
                <p class="text-xs text-slate-400 mt-0.5">Hasil komparasi luaran prediksi model LSTM terhadap sub-dataset uji
                    untuk validasi</p>
            </div>
            <a href="{{ route('detail-forecasting.index') }}"
                class="inline-flex items-center justify-center bg-slate-800 hover:bg-slate-900 text-white px-4 py-2.5 rounded-xl text-xs font-bold transition-colors no-underline border-0 cursor-pointer">
                <i class="bi bi-arrow-left me-1.5"></i>
                <span>Kembali</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center text-xl shrink-0 border border-blue-100/30">
                    <i class="bi bi-collection"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight leading-tight">
                        {{ $testingData->count() }}
                    </h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Ukuran Sampel Uji</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl shrink-0 border border-emerald-100/30">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div>
                    <h3 class="text-xl font-extrabold text-slate-800 tracking-tight leading-tight">
                        Rp {{ number_format($testingData->avg('aktual'), 0, ',', '.') }}
                    </h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Rata-rata Aktual</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-purple-50 text-purple-500 flex items-center justify-center text-xl shrink-0 border border-purple-100/30">
                    <i class="bi bi-graph-up"></i>
                </div>
                <div>
                    <h3 class="text-xl font-extrabold text-slate-800 tracking-tight leading-tight">
                        Rp {{ number_format($testingData->avg('prediksi'), 0, ',', '.') }}
                    </h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Rata-rata Prediksi</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center text-xl shrink-0 border border-rose-100/30">
                    <i class="bi bi-exclamation-circle"></i>
                </div>
                <div>
                    <h3 class="text-xl font-extrabold text-rose-600 tracking-tight leading-tight">
                        Rp {{ number_format($testingData->avg('selisih'), 0, ',', '.') }}
                    </h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Rata-rata Selisih Error
                    </p>
                </div>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col sm:flex-row gap-5 items-start justify-between">
            <div class="space-y-2 max-w-4xl">
                <h4 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="bi bi-info-circle text-emerald-600"></i> Konsep Validasi Prediksi Pengujian
                </h4>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">
                    Sub-dataset testing dialokasikan khusus sebagai himpunan data yang tidak pernah dilibatkan dalam fase
                    pembaruan bobot (*training model*). Model LSTM ditantang memproyeksikan nilai nominal omzet pada rentang
                    waktu ini, lalu hasilnya divalidasi silang secara langsung dengan rekaman data riil transaksi toko yang
                    asli.
                </p>
            </div>
            <div
                class="p-3 bg-slate-50 border border-slate-100 rounded-xl text-[11px] text-slate-500 leading-relaxed sm:max-w-xs shrink-0">
                <i class="bi bi-calculator text-slate-400 me-1"></i> Nilai selisih absolut dari setiap baris tabel di bawah
                ditampung ke dalam kalkulasi metrik akurasi <b>MAE, RMSE, dan MAPE</b>.
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="mb-4">
                <h4 class="text-base font-bold text-slate-800">Matriks Hasil Prediksi Data Testing</h4>
                <p class="text-xs text-slate-400 mt-0.5">Rincian lembar perbandingan log kalkulasi nilai aktual omzet eceran
                    terhadap hasil tebakan model</p>
            </div>

            <div class="overflow-x-auto rounded-xl border border-slate-100">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-50 border-b border-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider">
                            <th class="px-6 py-4 text-center w-20">No</th>
                            <th class="px-6 py-4">Nilai Aktual Riil</th>
                            <th class="px-6 py-4">Nilai Hasil Prediksi AI</th>
                            <th class="px-6 py-4 text-right pr-12">Selisih Margin Kesalahan (Error)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                        @forelse($testingData as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-center font-bold text-slate-400 bg-slate-50/10">
                                    {{ $loop->iteration }}</td>
                                <td class="px-6 py-4 font-semibold text-slate-700">
                                    Rp {{ number_format($item->aktual, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-purple-600">
                                    Rp {{ number_format($item->prediksi, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right pr-12 font-mono font-bold text-rose-600 bg-rose-50/10">
                                    Rp {{ number_format($item->selisih, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-12">
                                    <div
                                        class="w-11 h-11 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 mx-auto mb-3 text-lg border border-slate-100">
                                        <i class="bi bi-bar-chart-line"></i>
                                    </div>
                                    <p class="text-xs text-slate-400 font-medium">Belum ada rekaman log evaluasi data
                                        testing yang diproses.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

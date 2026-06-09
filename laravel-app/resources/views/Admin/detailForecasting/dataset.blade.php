@extends('layouts.app')

@section('title', 'Pembagian Dataset')

@section('content')
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">Pembagian Dataset</h1>
                <p class="text-xs text-slate-400 mt-0.5">Segmentasi partisi data training dan data testing berdasarkan rasio
                    parameter $80:20$</p>
            </div>
            <a href="{{ route('detail-forecasting.index') }}"
                class="inline-flex items-center justify-center bg-slate-800 hover:bg-slate-900 text-white px-4 py-2.5 rounded-xl text-xs font-bold transition-colors no-underline border-0 cursor-pointer">
                <i class="bi bi-arrow-left me-1.5"></i>
                <span>Kembali</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center text-xl shrink-0 border border-blue-100/30">
                    <i class="bi bi-folder2-open"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight leading-tight">
                        {{ number_format($totalData, 0, ',', '.') }}
                    </h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Total Keseluruhan Data
                    </p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl shrink-0 border border-emerald-100/30">
                    <i class="bi bi-gear-wide"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-emerald-600 tracking-tight leading-tight">
                        {{ number_format($trainSize, 0, ',', '.') }}
                    </h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Volume Data Training
                        ($80\%$)</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-xl shrink-0 border border-amber-100/30">
                    <i class="bi bi-check2-square"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-amber-600 tracking-tight leading-tight">
                        {{ number_format($testSize, 0, ',', '.') }}
                    </h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Volume Data Testing
                        ($20\%$)</p>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div
                class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-between">
                <div>
                    <h4 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <i class="bi bi-calculator text-emerald-600"></i> Perhitungan Proporsi Dataset
                    </h4>

                    <div
                        class="p-4 bg-slate-50 border border-slate-100/80 rounded-xl space-y-3.5 text-xs text-slate-600 font-medium">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400">Total Basis Data Penjualan Aktual</span>
                            <span class="font-bold text-slate-800 text-sm">{{ $totalData }} Baris entri</span>
                        </div>
                        <div class="border-t border-slate-200/60 my-1"></div>
                        <div class="flex justify-between items-center">
                            <span>Data Pembelajaran (Training)</span>
                            <span
                                class="text-slate-700 font-mono bg-white px-2 py-1 rounded border border-slate-200 shadow-sm">{{ $totalData }}
                                × 80% = <b class="text-emerald-600 font-bold">{{ $trainSize }}</b></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Data Validasi Pengujian (Testing)</span>
                            <span
                                class="text-slate-700 font-mono bg-white px-2 py-1 rounded border border-slate-200 shadow-sm">{{ $totalData }}
                                × 20% = <b class="text-amber-600 font-bold">{{ $testSize }}</b></span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 space-y-2">
                    <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Simulasi Distribusi
                        Data Fisik</span>
                    <div class="w-full bg-slate-100 rounded-full h-5 flex overflow-hidden p-0.5 border border-slate-200/50">
                        <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 h-full rounded-l-full flex items-center justify-center text-[10px] font-bold text-white shadow-inner"
                            style="width: 80%">
                            Training (80%)
                        </div>
                        <div class="bg-gradient-to-r from-amber-500 to-amber-600 h-full rounded-r-full flex items-center justify-center text-[10px] font-bold text-white shadow-inner"
                            style="width: 20%">
                            Testing (20%)
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-between">
                <div>
                    <h4 class="text-sm font-bold text-slate-800 mb-3 flex items-center gap-2">
                        <i class="bi bi-info-circle text-emerald-500"></i> Esensi Preprocessing
                    </h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Dataset dipecah secara sistematis tanpa pengacakan urutan waktu (*Time-Series Split*) demi menjaga
                        integritas siklus omzet harian.
                    </p>
                    <p class="text-xs text-slate-500 leading-relaxed mt-2.5">
                        <b>Data Training</b> diprioritaskan porsinya sebesar $80\%$ agar arsitektur lapisan sel memori
                        jaringan LSTM menangkap fluktuasi pola tren jangka panjang secara matang.
                    </p>
                </div>
                <div
                    class="mt-4 p-3 bg-blue-50/70 border border-blue-100/50 rounded-xl text-[11px] text-slate-600 leading-relaxed">
                    Sisa $20\%$ sisa data dialokasikan murni sebagai <b>Data Testing</b> untuk mengukur keandalan tingkat
                    akurasi prediksi tanpa bias over-fitting.
                </div>
            </div>

        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="mb-4">
                <h4 class="text-base font-bold text-slate-800">Ringkasan Tabel Distribusi</h4>
                <p class="text-xs text-slate-400 mt-0.5">Matriks pembagian proporsi kuantitas baris untuk pengolahan
                    komputasi data</p>
            </div>

            <div class="overflow-x-auto rounded-xl border border-slate-100">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-50 border-b border-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider">
                            <th class="px-6 py-4">Tipe Sub-Dataset</th>
                            <th class="px-6 py-4">Kuantitas Alokasi Baris</th>
                            <th class="px-6 py-4 text-right pr-12">Rasio Bobot Persentase</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-bold text-emerald-600 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <span>Data Training Pembelajaran</span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-700">
                                {{ number_format($trainSize, 0, ',', '.') }} Baris data
                            </td>
                            <td class="px-6 py-4 text-right pr-12 font-mono font-bold text-emerald-600 text-sm">
                                80%
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-bold text-amber-600 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                <span>Data Testing Pengujian</span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-700">
                                {{ number_format($testSize, 0, ',', '.') }} Baris data
                            </td>
                            <td class="px-6 py-4 text-right pr-12 font-mono font-bold text-amber-600 text-sm">
                                20%
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

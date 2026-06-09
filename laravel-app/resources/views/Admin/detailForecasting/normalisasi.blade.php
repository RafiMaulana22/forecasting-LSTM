@extends('layouts.app')

@section('title', 'Normalisasi Data')

@section('content')
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">Normalisasi Data</h1>
                <p class="text-xs text-slate-400 mt-0.5">Tahap preprocessing transformasi data menggunakan metode Min-Max
                    Scaling</p>
            </div>
            <a href="{{ route('detail-forecasting.index') }}"
                class="inline-flex items-center justify-center bg-slate-800 hover:bg-slate-900 text-white px-4 py-2.5 rounded-xl text-xs font-bold transition-colors no-underline border-0 cursor-pointer">
                <i class="bi bi-arrow-left me-1.5"></i>
                <span>Kembali</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center text-xl shrink-0 border border-blue-100/30">
                    <i class="bi bi-arrow-down-circle"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight leading-tight">
                        Rp {{ number_format($min, 0, ',', '.') }}
                    </h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Nilai Batas Minimum
                        ($X_{min}$)</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl shrink-0 border border-emerald-100/30">
                    <i class="bi bi-arrow-up-circle"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight leading-tight">
                        Rp {{ number_format($max, 0, ',', '.') }}
                    </h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Nilai Batas Maksimum
                        ($X_{max}$)</p>
                </div>
            </div>

        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <h4 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                <i class="bi bi-calculator text-emerald-600"></i> Formulasi Matematis Scaling
            </h4>

            <div class="bg-slate-50 py-5 px-4 rounded-xl text-center border border-slate-100/80 shadow-inner">
                <p class="text-xl font-mono tracking-wide text-slate-800">
                    $$X' = \frac{X - X_{min}}{X_{max} - X_{min}}$$
                </p>
            </div>

            <div class="mt-5 grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
                <div class="p-3 bg-slate-50/50 rounded-xl border border-slate-100">
                    <span class="block text-slate-400 font-bold uppercase text-[9px] tracking-wider">Komponen X'</span>
                    <span class="text-slate-700 font-semibold mt-0.5 block">Hasil Normalisasi</span>
                </div>
                <div class="p-3 bg-slate-50/50 rounded-xl border border-slate-100">
                    <span class="block text-slate-400 font-bold uppercase text-[9px] tracking-wider">Komponen X</span>
                    <span class="text-slate-700 font-semibold mt-0.5 block">Data Aktual Riil</span>
                </div>
                <div class="p-3 bg-slate-50/50 rounded-xl border border-slate-100">
                    <span class="block text-slate-400 font-bold uppercase text-[9px] tracking-wider">Komponen Xmin</span>
                    <span class="text-slate-700 font-semibold mt-0.5 block">Nilai Terendah</span>
                </div>
                <div class="p-3 bg-slate-50/50 rounded-xl border border-slate-100">
                    <span class="block text-slate-400 font-bold uppercase text-[9px] tracking-wider">Komponen Xmax</span>
                    <span class="text-slate-700 font-semibold mt-0.5 block">Nilai Tertinggi</span>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="mb-4">
                <h4 class="text-base font-bold text-slate-800">Hasil Normalisasi Dataset</h4>
                <p class="text-xs text-slate-400 mt-0.5">Representasi matriks nilai omzet setelah dikonversi ke dalam
                    rentang skala $[0, 1]$</p>
            </div>

            <div class="overflow-x-auto rounded-xl border border-slate-100">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-50 border-b border-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider">
                            <th class="px-6 py-4 text-center w-20">No</th>
                            <th class="px-6 py-4">Tanggal Penjualan</th>
                            <th class="px-6 py-4">Pendapatan Aktual Toko</th>
                            <th class="px-6 py-4 text-right pr-12">Nilai Hasil Transformasi (Scaling)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                        @foreach ($normalisasi as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-center font-bold text-slate-400">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 font-medium text-slate-700">
                                    {{ \Carbon\Carbon::parse($item['tanggal'])->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-slate-800">
                                    Rp {{ number_format($item['aktual'], 0, ',', '.') }}
                                </td>
                                <td
                                    class="px-6 py-4 text-right pr-12 font-mono font-bold text-emerald-600 text-sm tracking-wide bg-emerald-50/10">
                                    {{ number_format($item['normalisasi'], 6, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

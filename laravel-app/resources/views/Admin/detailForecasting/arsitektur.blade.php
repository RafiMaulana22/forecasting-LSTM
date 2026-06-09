@extends('layouts.app')

@section('title', 'Arsitektur Model LSTM')

@section('content')
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">Arsitektur Model LSTM</h1>
                <p class="text-xs text-slate-400 mt-0.5">Struktur dan konfigurasi topologi jaringan saraf Long Short-Term
                    Memory dalam penelitian</p>
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
                    <i class="bi bi-clock-history"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight leading-tight">
                        {{ $arsitektur['timestep'] }}</h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Interval Time Step</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-purple-50 text-purple-500 flex items-center justify-center text-xl shrink-0 border border-purple-100/30">
                    <i class="bi bi-cpu"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight leading-tight">
                        {{ $arsitektur['lstm_neuron'] }}</h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Jumlah Neuron LSTM</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl shrink-0 border border-emerald-100/30">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight leading-tight">
                        {{ $arsitektur['epoch'] }}</h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Batas Maks Epoch</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-xl shrink-0 border border-amber-100/30">
                    <i class="bi bi-layers"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight leading-tight">
                        {{ $arsitektur['batch_size'] }}</h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Ukuran Batch Size</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-100">
            <h4 class="text-sm font-bold text-slate-800 mb-6 flex items-center gap-2">
                <i class="bi bi-diagram-3 text-emerald-600"></i> Diagram Rangkaian Aliran Model Layer
            </h4>

            <div class="flex flex-col items-center max-w-md mx-auto relative my-2">

                <div
                    class="w-full bg-slate-50 border border-slate-200 p-4 rounded-xl text-center shadow-sm relative group hover:border-blue-300 transition-colors">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 w-2 h-8 bg-blue-500 rounded-full"></span>
                    <h5 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Lapisan Masukan</h5>
                    <p class="text-sm font-extrabold text-slate-800 mt-1">Input Layer</p>
                    <span
                        class="inline-block mt-1 text-[10px] font-bold font-mono text-blue-600 bg-blue-50 border border-blue-100 px-2 py-0.5 rounded">({{ $arsitektur['timestep'] }}
                        Time Steps &times; 1 Fitur)</span>
                </div>

                <div class="py-2 text-slate-300 flex items-center justify-center">
                    <i class="bi bi-arrow-down-short text-3xl animate-bounce"></i>
                </div>

                <div
                    class="w-full bg-slate-50 border border-slate-200 p-4 rounded-xl text-center shadow-sm relative group hover:border-purple-300 transition-colors">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 w-2 h-8 bg-purple-500 rounded-full"></span>
                    <h5 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Lapisan Memori Recurrent</h5>
                    <p class="text-sm font-extrabold text-slate-800 mt-1">LSTM Layer</p>
                    <span
                        class="inline-block mt-1 text-[10px] font-bold font-mono text-purple-600 bg-purple-50 border border-purple-100 px-2 py-0.5 rounded">({{ $arsitektur['lstm_neuron'] }}
                        Hidden Units)</span>
                </div>

                <div class="py-2 text-slate-300 flex items-center justify-center">
                    <i class="bi bi-arrow-down-short text-3xl"></i>
                </div>

                <div
                    class="w-full bg-slate-50 border border-slate-200 p-4 rounded-xl text-center shadow-sm relative group hover:border-emerald-300 transition-colors">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 w-2 h-8 bg-emerald-500 rounded-full"></span>
                    <h5 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Lapisan Terhubung Penuh</h5>
                    <p class="text-sm font-extrabold text-slate-800 mt-1">Dense Layer (Linear)</p>
                    <span
                        class="inline-block mt-1 text-[10px] font-bold font-mono text-emerald-600 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded">(1
                        Output Neuron)</span>
                </div>

                <div class="py-2 text-slate-300 flex items-center justify-center">
                    <i class="bi bi-arrow-down-short text-3xl"></i>
                </div>

                <div
                    class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 p-4 rounded-xl text-center shadow-md shadow-emerald-900/10 text-white">
                    <h5 class="text-xs font-bold text-emerald-100 uppercase tracking-wider">Hasil Proyeksi Akhir</h5>
                    <p class="text-sm font-black mt-0.5 tracking-wide">Output Prediksi</p>
                    <span
                        class="inline-block mt-1 text-[10px] font-bold uppercase tracking-wider bg-white/15 border border-white/10 px-2 py-0.5 rounded">Proyeksi
                        Pendapatan t+1</span>
                </div>

            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <h4 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                <i class="bi bi-sliders2-vertical text-emerald-600"></i> Rincian Parameter Hiperparameter Model
            </h4>

            <div class="overflow-x-auto rounded-xl border border-slate-100">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr
                            class="bg-slate-50 border-b border-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider">
                            <th class="px-6 py-3.5 w-1/2">Nama Atribut Parameter</th>
                            <th class="px-6 py-3.5">Nilai Konfigurasi Kuantitatif</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-600 font-medium">
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-slate-500">Dimensi Masukan (Input Shape)</td>
                            <td class="px-6 py-4 font-mono font-bold text-slate-800">({{ $arsitektur['timestep'] }}, 1)</td>
                        </tr>
                        <tr class="bg-slate-50/30 hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-slate-500">Unit Sel Lapisan LSTM (LSTM Units)</td>
                            <td class="px-6 py-4 font-mono font-bold text-purple-600">{{ $arsitektur['lstm_neuron'] }} Nodes
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-slate-500">Unit Lapisan Terhubung (Dense Units)</td>
                            <td class="px-6 py-4 font-mono font-bold text-emerald-600">1 Node</td>
                        </tr>
                        <tr class="bg-slate-50/30 hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-slate-500">Fungsi Optimasi Gradien (Optimizer)</td>
                            <td class="px-6 py-4 font-bold text-slate-800 flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                <span>Adam</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-slate-500">Fungsi Kerugian Selisih (Loss Function)</td>
                            <td class="px-6 py-4 text-slate-700">Mean Squared Error (MSE)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

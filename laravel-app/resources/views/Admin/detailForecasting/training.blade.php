@extends('layouts.app')

@section('title', 'Training Model LSTM')

@section('content')
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">Training Model LSTM</h1>
                <p class="text-xs text-slate-400 mt-0.5">Proses pelatihan optimasi bobot arsitektur jaringan saraf
                    menggunakan sub-dataset training</p>
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
                    class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl shrink-0 border border-emerald-100/30">
                    <i class="bi bi-hdd-network"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight leading-tight">
                        {{ number_format($trainSize) }}</h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Baris Data Training</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-purple-50 text-purple-500 flex items-center justify-center text-xl shrink-0 border border-purple-100/30">
                    <i class="bi bi-list-nested"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight leading-tight">
                        {{ number_format($totalTrainSequence) }}</h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Total Blok Sequence</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center text-xl shrink-0 border border-blue-100/30">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight leading-tight">
                        {{ $trainingConfig['epoch'] }}</h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Target Iterasi Epoch</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-xl shrink-0 border border-amber-100/30">
                    <i class="bi bi-layers"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight leading-tight">
                        {{ $trainingConfig['batch_size'] }}</h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Ukuran Kuantitas Batch
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div
                class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-between">
                <div class="space-y-4">
                    <h4 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i class="bi bi-info-circle text-emerald-600"></i> Mekanisme Siklus Pelatihan Model
                    </h4>
                    <div class="text-xs text-slate-500 leading-relaxed space-y-3 font-medium">
                        <p>
                            Matriks urutan waktu (*Data sequence*) hasil ekstraksi *sliding window* diumpankan secara
                            berkala ke dalam sel komputasi LSTM. Proses ini bertujuan melatih model dalam mengenali korelasi
                            non-linier dari data omzet harian.
                        </p>
                        <p>
                            Sistem menjalankan proses pelatihan sebanyak <span
                                class="text-slate-800 font-bold">{{ $trainingConfig['epoch'] }} siklus penuh (epoch)</span>.
                            Di setiap iterasinya, sampel data dipecah ke dalam kelompok kecil berukuran <span
                                class="text-slate-800 font-bold">batch size {{ $trainingConfig['batch_size'] }}</span> guna
                            mengefisiensikan konsumsi alokasi memori *hardware*.
                        </p>
                        <p>
                            Evaluasi tingkat melesetnya prediksi dihitung menggunakan kriteria fungsi loss <span
                                class="text-slate-800 font-bold">{{ $trainingConfig['loss_function'] }}</span>. Selanjutnya,
                            algoritma optimasi berbasis <span
                                class="text-slate-800 font-bold">{{ $trainingConfig['optimizer'] }}</span> akan memperbarui
                            matriks nilai bobot internal secara otomatis guna memperkecil tingkat error di iterasi
                            berikutnya.
                        </p>
                    </div>
                </div>

                <div
                    class="mt-4 p-3 bg-emerald-50/50 border border-emerald-100/50 rounded-xl text-[11px] text-emerald-800 flex gap-2 items-center">
                    <i class="bi bi-shield-check text-sm text-emerald-500"></i>
                    <span>Bobot model yang paling optimal akan disimpan secara otomatis untuk digunakan pada fase
                        forecasting 7 hari.</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h4 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i class="bi bi-sliders2-vertical text-emerald-600"></i> Hiperparameter Nilai Tetap
                </h4>

                <div class="overflow-x-auto rounded-xl border border-slate-100">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr
                                class="bg-slate-50 border-b border-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider">
                                <th class="px-4 py-3">Atribut Model</th>
                                <th class="px-4 py-3">Nilai Tetap</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-600 font-semibold">
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-4 py-3 text-slate-400 font-normal">Optimizer</td>
                                <td class="px-4 py-3 text-slate-800 flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    <span>{{ $trainingConfig['optimizer'] }}</span>
                                </td>
                            </tr>
                            <tr class="bg-slate-50/30 hover:bg-slate-50/50 transition-colors">
                                <td class="px-4 py-3 text-slate-400 font-normal">Loss Function</td>
                                <td class="px-4 py-3 text-slate-700">{{ $trainingConfig['loss_function'] }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-4 py-3 text-slate-400 font-normal">Epoch Target</td>
                                <td class="px-4 py-3 text-blue-600 font-mono">{{ $trainingConfig['epoch'] }} Iterasi</td>
                            </tr>
                            <tr class="bg-slate-50/30 hover:bg-slate-50/50 transition-colors">
                                <td class="px-4 py-3 text-slate-400 font-normal">Batch Size</td>
                                <td class="px-4 py-3 text-amber-600 font-mono">{{ $trainingConfig['batch_size'] }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-4 py-3 text-slate-400 font-normal">LSTM Hidden Units</td>
                                <td class="px-4 py-3 text-purple-600 font-mono">{{ $trainingConfig['lstm_units'] }} Nodes
                                </td>
                            </tr>
                            <tr class="bg-slate-50/30 hover:bg-slate-50/50 transition-colors">
                                <td class="px-4 py-3 text-slate-400 font-normal">Dense Layer Units</td>
                                <td class="px-4 py-3 text-slate-800 font-mono">{{ $trainingConfig['dense_units'] }} Node
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-100">
            <h4 class="text-sm font-bold text-slate-800 mb-6 flex items-center gap-2">
                <i class="bi bi-arrow-repeat text-emerald-600"></i> Diagram Urutan Alir Siklus Epoking Model
            </h4>

            <div class="flex flex-col items-center max-w-sm mx-auto relative my-2 text-xs font-bold text-slate-700">

                <div
                    class="w-full bg-slate-50 border border-slate-200 p-3.5 rounded-xl text-center shadow-sm relative group hover:border-blue-200 transition-colors">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 w-1.5 h-6 bg-blue-500 rounded-full"></span>
                    <span>Matriks Masukan (Sequence Training)</span>
                </div>

                <div class="py-1.5 text-slate-300"><i class="bi bi-arrow-down fs-5"></i></div>

                <div
                    class="w-full bg-slate-50 border border-slate-200 p-3.5 rounded-xl text-center shadow-sm relative group hover:border-purple-200 transition-colors">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 w-1.5 h-6 bg-purple-500 rounded-full"></span>
                    <span>Ekstraksi Memori Lapisan LSTM ({{ $trainingConfig['lstm_units'] }} Units)</span>
                </div>

                <div class="py-1.5 text-slate-300"><i class="bi bi-arrow-down fs-5"></i></div>

                <div
                    class="w-full bg-slate-50 border border-slate-200 p-3.5 rounded-xl text-center shadow-sm relative group hover:border-emerald-200 transition-colors">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 w-1.5 h-6 bg-emerald-500 rounded-full"></span>
                    <span>Penyatuan Node Dimensi (Dense Layer)</span>
                </div>

                <div class="py-1.5 text-slate-300"><i class="bi bi-arrow-down fs-5"></i></div>

                <div
                    class="w-full bg-slate-50 border border-slate-200 p-3.5 rounded-xl text-center shadow-sm relative group hover:border-amber-200 transition-colors">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 w-1.5 h-6 bg-amber-500 rounded-full"></span>
                    <span>Kalkulasi Nilai Error Loss ({{ $trainingConfig['loss_function'] }})</span>
                </div>

                <div class="py-1.5 text-slate-300"><i class="bi bi-arrow-down fs-5"></i></div>

                <div
                    class="w-full bg-slate-50 border border-slate-200 p-3.5 rounded-xl text-center shadow-sm relative group hover:border-rose-200 transition-colors">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 w-1.5 h-6 bg-rose-500 rounded-full"></span>
                    <span>Pembaruan Bobot Sel Model ({{ $trainingConfig['optimizer'] }} Optimizer)</span>
                </div>

                <div class="py-1.5 text-slate-300"><i class="bi bi-arrow-down fs-5"></i></div>

                <div
                    class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 p-4 rounded-xl text-center shadow-md shadow-emerald-900/10 text-white">
                    <span class="block text-[10px] text-emerald-100 uppercase tracking-wider font-bold">Kondisi Berhenti
                        Iterasi</span>
                    <p class="font-black tracking-wide text-sm mt-0.5">Ulangi Siklus Alur Berkelanjutan</p>
                    <span
                        class="inline-block mt-1 text-[10px] font-bold bg-white/15 px-2 py-0.5 rounded border border-white/10">Hingga
                        Menyentuh Batas {{ $trainingConfig['epoch'] }} Epoch</span>
                </div>

            </div>
        </div>

    </div>
@endsection

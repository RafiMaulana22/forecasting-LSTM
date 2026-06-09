@extends('layouts.app')

@section('title', 'Detail Forecasting')

@section('content')
    <div class="space-y-6">

        <div
            class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">
                    Detail Proses Forecasting LSTM
                </h1>
                <p class="text-xs text-slate-400 mt-1 leading-relaxed max-w-3xl">
                    Menampilkan seluruh tahapan proses komputasi mulai dari preprocessing data, pembentukan sequence,
                    training arsitektur model LSTM, hingga evaluasi kalkulasi hasil prediksi harian.
                </p>
            </div>
            <a href="{{ route('forecasting.index') }}"
                class="inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-900 text-white px-4 py-2.5 rounded-xl text-xs font-bold transition-colors no-underline border-0 cursor-pointer shrink-0">
                <i class="bi bi-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <h4 class="text-sm font-bold text-slate-800 mb-5 flex items-center gap-2">
                <i class="bi bi-cpu text-emerald-600"></i> Pilih Tahapan Eksperimen Model
            </h4>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                <a href="{{ route('detail-forecasting.normalisasi') }}"
                    class="group p-5 bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] hover:border-blue-200 hover:bg-blue-50/20 transition-all duration-200 hover:-translate-y-1 no-underline block">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center text-xl shrink-0 border border-blue-100/30 group-hover:bg-blue-500 group-hover:text-white transition-colors duration-200">
                            <i class="bi bi-sliders"></i>
                        </div>
                        <div>
                            <h5 class="font-bold text-slate-700 text-sm group-hover:text-blue-600 transition-colors">
                                Normalisasi</h5>
                            <p class="text-[11px] text-slate-400 font-medium mt-0.5">Min-Max Scaling</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('detail-forecasting.dataset') }}"
                    class="group p-5 bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] hover:border-amber-200 hover:bg-amber-50/20 transition-all duration-200 hover:-translate-y-1 no-underline block">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-xl shrink-0 border border-amber-100/30 group-hover:bg-amber-500 group-hover:text-white transition-colors duration-200">
                            <i class="bi bi-pie-chart"></i>
                        </div>
                        <div>
                            <h5 class="font-bold text-slate-700 text-sm group-hover:text-amber-600 transition-colors">Bagi
                                Dataset</h5>
                            <p class="text-[11px] text-slate-400 font-medium mt-0.5">Rasio 80% : 20%</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('detail-forecasting.sequence') }}"
                    class="group p-5 bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] hover:border-purple-200 hover:bg-purple-50/20 transition-all duration-200 hover:-translate-y-1 no-underline block">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-purple-50 text-purple-500 flex items-center justify-center text-xl shrink-0 border border-purple-100/30 group-hover:bg-purple-500 group-hover:text-white transition-colors duration-200">
                            <i class="bi bi-list-ol"></i>
                        </div>
                        <div>
                            <h5 class="font-bold text-slate-700 text-sm group-hover:text-purple-600 transition-colors">
                                Sequence Data</h5>
                            <p class="text-[11px] text-slate-400 font-medium mt-0.5">Window Size 7</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('detail-forecasting.arsitektur') }}"
                    class="group p-5 bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] hover:border-emerald-200 hover:bg-emerald-50/20 transition-all duration-200 hover:-translate-y-1 no-underline block">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl shrink-0 border border-emerald-100/30 group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-200">
                            <i class="bi bi-cpu"></i>
                        </div>
                        <div>
                            <h5 class="font-bold text-slate-700 text-sm group-hover:text-emerald-600 transition-colors">
                                Arsitektur</h5>
                            <p class="text-[11px] text-slate-400 font-medium mt-0.5">50 Hidden Units</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('detail-forecasting.training') }}"
                    class="group p-5 bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] hover:border-indigo-200 hover:bg-indigo-50/20 transition-all duration-200 hover:-translate-y-1 no-underline block">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-500 flex items-center justify-center text-xl shrink-0 border border-indigo-100/30 group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-200">
                            <i class="bi bi-gear-wide-connected"></i>
                        </div>
                        <div>
                            <h5 class="font-bold text-slate-700 text-sm group-hover:text-indigo-600 transition-colors">
                                Training Model</h5>
                            <p class="text-[11px] text-slate-400 font-medium mt-0.5">Iterasi 20 Epoch</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('detail-forecasting.hasil-training') }}"
                    class="group p-5 bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] hover:border-cyan-200 hover:bg-cyan-50/20 transition-all duration-200 hover:-translate-y-1 no-underline block">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-cyan-50 text-cyan-500 flex items-center justify-center text-xl shrink-0 border border-cyan-100/30 group-hover:bg-cyan-500 group-hover:text-white transition-colors duration-200">
                            <i class="bi bi-graph-down"></i>
                        </div>
                        <div>
                            <h5 class="font-bold text-slate-700 text-sm group-hover:text-cyan-600 transition-colors">Hasil
                                Training</h5>
                            <p class="text-[11px] text-slate-400 font-medium mt-0.5">Visualisasi Loss</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('detail-forecasting.testing') }}"
                    class="group p-5 bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] hover:border-rose-200 hover:bg-rose-50/20 transition-all duration-200 hover:-translate-y-1 no-underline block">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center text-xl shrink-0 border border-rose-100/30 group-hover:bg-rose-500 group-hover:text-white transition-colors duration-200">
                            <i class="bi bi-bar-chart-line"></i>
                        </div>
                        <div>
                            <h5 class="font-bold text-slate-700 text-sm group-hover:text-rose-600 transition-colors">
                                Prediksi Testing</h5>
                            <p class="text-[11px] text-slate-400 font-medium mt-0.5">Uji Validasi Data</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('detail-forecasting.evaluasi') }}"
                    class="group p-5 bg-white rounded-2xl border border-slate-100 shadow-[0_4px_20px_rgba(0,0,0,0.02)] hover:border-orange-200 hover:bg-orange-50/20 transition-all duration-200 hover:-translate-y-1 no-underline block">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center text-xl shrink-0 border border-orange-100/30 group-hover:bg-orange-500 group-hover:text-white transition-colors duration-200">
                            <i class="bi bi-clipboard-data"></i>
                        </div>
                        <div>
                            <h5 class="font-bold text-slate-700 text-sm group-hover:text-orange-600 transition-colors">
                                Evaluasi Metrik</h5>
                            <p class="text-[11px] text-slate-400 font-medium mt-0.5">MAE • RMSE • MAPE</p>
                        </div>
                    </div>
                </a>

            </div>

            <div class="mt-5">
                <a href="{{ route('detail-forecasting.forecast') }}"
                    class="group p-6 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl shadow-sm text-white transition-all duration-200 hover:shadow-md hover:from-emerald-700 hover:to-teal-700 no-underline flex items-center justify-between relative overflow-hidden">
                    <div class="flex items-center gap-4 z-10">
                        <div
                            class="w-14 h-14 rounded-xl bg-white/10 flex items-center justify-center text-2xl text-white border border-white/10 group-hover:scale-110 transition-transform">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <div>
                            <h5 class="font-extrabold text-white text-base">Forecast Akhir 7 Hari</h5>
                            <p class="text-xs text-emerald-100/80 font-medium mt-0.5">Melihat hasil proyeksi final
                                pendapatan bersih masa depan warung</p>
                        </div>
                    </div>
                    <div class="text-white/80 pr-4 z-10 hidden sm:block">
                        <i class="bi bi-chevron-right text-xl"></i>
                    </div>
                    <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-white/5 rounded-full pointer-events-none"></div>
                </a>
            </div>

        </div>

    </div>
@endsection

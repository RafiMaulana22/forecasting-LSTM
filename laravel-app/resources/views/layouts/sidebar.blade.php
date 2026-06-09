@php
    $current = Request::segment(1);
@endphp

<div
    class="h-full flex flex-col justify-between bg-gradient-to-b from-slate-900 via-slate-950 to-slate-950 text-slate-300">

    <div>
        <div class="flex items-center gap-3 px-6 py-6 border-b border-slate-800/50">
            <div
                class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-lg text-emerald-400 border border-emerald-500/20 shrink-0">
                <i class="bi bi-graph-up-arrow flex items-center justify-center"></i>
            </div>
            <div>
                <h5 class="m-0 text-sm font-bold text-white tracking-wide leading-tight">
                    KasirKu <span class="text-emerald-400">AI</span>
                </h5>
                <p class="text-[10px] text-slate-400 font-medium mt-0.5 whitespace-nowrap">
                    Peramalan Toko Sembako
                </p>
            </div>
        </div>

        <nav class="mt-6 px-3 flex flex-col gap-1">

            <a href="/dashboard"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold tracking-wide transition-all duration-200 no-underline
                {{ $current == 'dashboard' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-950/50' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <i class="bi bi-speedometer2 text-base"></i>
                <span>Dashboard</span>
            </a>

            <a href="/pendapatan"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold tracking-wide transition-all duration-200 no-underline
                {{ $current == 'pendapatan' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-950/50' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <i class="bi bi-cash-stack text-base"></i>
                <span>Data Pendapatan</span>
            </a>

            <a href="/forecasting"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold tracking-wide transition-all duration-200 no-underline
                {{ $current == 'forecasting' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-950/50' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <i class="bi bi-cpu text-base"></i>
                <span>Proses Forecasting</span>
            </a>

            <a href="/hasil-prediksi"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold tracking-wide transition-all duration-200 no-underline
                {{ $current == 'hasil-prediksi' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-950/50' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <i class="bi bi-graph-up text-base"></i>
                <span>Hasil Prediksi 7 Hari</span>
            </a>

        </nav>
    </div>

    <div class="p-4">
        <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-800/30 border border-slate-800/60">
            <div
                class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-400 shrink-0">
                <i class="bi bi-robot flex items-center justify-center"></i>
            </div>
            <div class="overflow-hidden">
                <span class="block text-[9px] text-slate-500 font-bold uppercase tracking-wider">Engine Model</span>
                <span class="block text-[11px] font-semibold text-slate-200 truncate mt-0.5">
                    LSTM Neural Network
                </span>
            </div>
        </div>
    </div>

</div>

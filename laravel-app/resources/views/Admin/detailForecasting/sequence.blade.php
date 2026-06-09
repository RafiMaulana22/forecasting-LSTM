@extends('layouts.app')

@section('title', 'Pembentukan Sequence Data')

@section('content')
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">Pembentukan Sequence Data</h1>
                <p class="text-xs text-slate-400 mt-0.5">Transformasi deret waktu ke dalam format struktur matriks pengawasan
                    (*supervised learning*)</p>
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
                    <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight leading-tight">{{ $timestep }} Hari
                    </h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Konfigurasi Lag / Time
                        Step</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl shrink-0 border border-emerald-100/30">
                    <i class="bi bi-hdd-network"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight leading-tight">
                        {{ number_format($trainSize, 0, ',', '.') }}</h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Total Baris Training</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-purple-50 text-purple-500 flex items-center justify-center text-xl shrink-0 border border-purple-100/30">
                    <i class="bi bi-list-nested"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-purple-600 tracking-tight leading-tight">
                        {{ number_format($totalTrainSequence, 0, ',', '.') }}</h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Matriks Sequence Train
                    </p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-xl shrink-0 border border-amber-100/30">
                    <i class="bi bi-list-stars"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-amber-600 tracking-tight leading-tight">
                        {{ number_format($totalTestSequence, 0, ',', '.') }}</h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Matriks Sequence Test
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 space-y-4">
            <h4 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                <i class="bi bi-layout-three-columns text-emerald-600"></i> Mekanisme Jendela Geser (Sliding Window)
            </h4>
            <div class="text-xs text-slate-500 leading-relaxed space-y-2.5 max-w-4xl">
                <p>
                    Model arsitektur recurrent seperti <b>Long Short-Term Memory (LSTM)</b> membutuhkan masukan dimensi
                    urutan tiga arah. Oleh karena itu, deret waktu tunggal omzet eceran warung harus dipetakan ulang menjadi
                    pasangan nilai fitur input ($X$) dan nilai target label ($Y$).
                </p>
                <p>
                    Melalui ketetapan interval sebesar <b>{{ $timestep }} hari harian sebelumnya</b>, sistem mengunci
                    rangkaian data historis dari Hari ke-1 hingga Hari ke-7 sebagai prediktor, kemudian memproyeksikan
                    perolehan nilai nominal omzet pada <b>Hari ke-8 berikutnya</b> sebagai sasaran kebenaran komputasi
                    jaringan saraf.
                </p>
            </div>

            <div
                class="mt-4 p-4 bg-slate-50 border border-slate-100/80 rounded-xl flex flex-col sm:flex-row items-center justify-center gap-4 text-xs font-semibold">
                <div class="flex items-center gap-1.5 flex-wrap justify-center">
                    <span class="px-2.5 py-1.5 bg-white rounded-lg border border-slate-200 text-slate-700 shadow-sm">Hari
                        1</span>
                    <span class="text-slate-300"><i class="bi bi-arrow-right-short"></i></span>
                    <span class="px-2.5 py-1.5 bg-white rounded-lg border border-slate-200 text-slate-700 shadow-sm">Hari
                        2</span>
                    <span class="text-slate-300"><i class="bi bi-arrow-right-short"></i></span>
                    <span
                        class="px-2.5 py-1.5 bg-white rounded-lg border border-slate-200 text-slate-700 shadow-sm">...</span>
                    <span class="text-slate-300"><i class="bi bi-arrow-right-short"></i></span>
                    <span class="px-2.5 py-1.5 bg-white rounded-lg border border-slate-200 text-slate-700 shadow-sm">Hari
                        7</span>
                </div>
                <div class="text-slate-400 font-bold uppercase text-[10px] bg-slate-200/60 px-2 py-1 rounded-md">Input Fitur
                    (X)</div>
                <div class="text-emerald-500 text-lg"><i class="bi bi-arrow-right-circle-fill"></i></div>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1.5 bg-emerald-600 text-white rounded-lg shadow-sm font-bold">Hari 8</span>
                    <span class="text-slate-400 font-bold uppercase text-[10px] bg-slate-200/60 px-2 py-1 rounded-md">Target
                        (Y)</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-between">
                <div class="mb-4">
                    <h4 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i class="bi bi-collection-play text-purple-500"></i> Matriks Urutan Data Training
                    </h4>
                    <p class="text-[11px] text-slate-400 mt-0.5">Konversi baris berskala pasca normalisasi Min-Max untuk
                        fase pelatihan</p>
                </div>

                <div class="overflow-x-auto rounded-xl border border-slate-100 max-h-[420px] overflow-y-auto">
                    <table class="w-full text-left border-collapse">
                        <thead
                            class="sticky top-0 z-10 bg-slate-50 border-b border-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider">
                            <tr>
                                <th class="px-4 py-3 text-center w-16">Seq</th>
                                <th class="px-4 py-3">Rangkaian Nilai Input ($X_{1}$ s/d $X_{7}$)</th>
                                <th class="px-4 py-3 text-right pr-6">Target ($Y$)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-[11px] text-slate-600">
                            @foreach ($trainSequence as $item)
                                <tr class="hover:bg-slate-50/40 transition-colors">
                                    <td class="px-4 py-4 text-center font-bold text-slate-400 bg-slate-50/20">
                                        #{{ $item['sequence_ke'] }}</td>
                                    <td class="px-4 py-4 space-y-1">
                                        @foreach ($item['input'] as $index => $value)
                                            <div class="flex items-center justify-between max-w-xs text-slate-500">
                                                <span>Hari {{ $index + 1 }} <span
                                                        class="text-[10px] text-slate-400">({{ \Carbon\Carbon::parse($value['tanggal'])->format('d/m') }})</span></span>
                                                <span
                                                    class="font-mono text-slate-700 font-semibold">{{ number_format($value['nilai'], 6, ',', '.') }}</span>
                                            </div>
                                        @endforeach
                                    </td>
                                    <td class="px-4 py-4 text-right pr-6 bg-purple-50/10">
                                        <span
                                            class="block font-semibold text-slate-700">{{ \Carbon\Carbon::parse($item['target_tanggal'])->format('d/m/Y') }}</span>
                                        <span
                                            class="block font-mono font-bold text-purple-600 text-xs mt-0.5">{{ number_format($item['target'], 6, ',', '.') }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-between">
                <div class="mb-4">
                    <h4 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i class="bi bi-collection-check text-amber-500"></i> Matriks Urutan Data Testing
                    </h4>
                    <p class="text-[11px] text-slate-400 mt-0.5">Konversi baris berskala pasca normalisasi Min-Max untuk
                        fase uji validasi</p>
                </div>

                <div class="overflow-x-auto rounded-xl border border-slate-100 max-h-[420px] overflow-y-auto">
                    <table class="w-full text-left border-collapse">
                        <thead
                            class="sticky top-0 z-10 bg-slate-50 border-b border-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider">
                            <tr>
                                <th class="px-4 py-3 text-center w-16">Seq</th>
                                <th class="px-4 py-3">Rangkaian Nilai Input ($X_{1}$ s/d $X_{7}$)</th>
                                <th class="px-4 py-3 text-right pr-6">Target ($Y$)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-[11px] text-slate-600">
                            @foreach ($testSequence as $item)
                                <tr class="hover:bg-slate-50/40 transition-colors">
                                    <td class="px-4 py-4 text-center font-bold text-slate-400 bg-slate-50/20">
                                        #{{ $item['sequence_ke'] }}</td>
                                    <td class="px-4 py-4 space-y-1">
                                        @foreach ($item['input'] as $index => $value)
                                            <div class="flex items-center justify-between max-w-xs text-slate-500">
                                                <span>Hari {{ $index + 1 }} <span
                                                        class="text-[10px] text-slate-400">({{ \Carbon\Carbon::parse($value['tanggal'])->format('d/m') }})</span></span>
                                                <span
                                                    class="font-mono text-slate-700 font-semibold">{{ number_format($value['nilai'], 6, ',', '.') }}</span>
                                            </div>
                                        @endforeach
                                    </td>
                                    <td class="px-4 py-4 text-right pr-6 bg-amber-50/10">
                                        <span
                                            class="block font-semibold text-slate-700">{{ \Carbon\Carbon::parse($item['target_tanggal'])->format('d/m/Y') }}</span>
                                        <span
                                            class="block font-mono font-bold text-amber-600 text-xs mt-0.5">{{ number_format($item['target'], 6, ',', '.') }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
@endsection

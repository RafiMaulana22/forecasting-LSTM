@extends('layouts.app')

@section('title', 'Data Pendapatan')

@section('content')
    <div class="space-y-6" x-data="{ modalTambah: false, modalImport: false }">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">Data Pendapatan</h1>
                <p class="text-xs text-slate-400 mt-0.5">Kelola data historis omzet harian asli Warung Sembako Madura</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <button @click="modalImport = true"
                    class="inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-50 text-slate-600 px-4 py-2.5 rounded-xl text-xs font-bold border border-slate-200 shadow-sm transition-all duration-150 cursor-pointer">
                    <i class="bi bi-file-earmark-excel text-emerald-600 text-sm"></i>
                    <span>Import Dataset</span>
                </button>

                <button @click="modalTambah = true"
                    class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-xl text-xs font-bold shadow-md shadow-emerald-900/10 transition-all duration-150 cursor-pointer border-0">
                    <i class="bi bi-plus-circle text-sm"></i>
                    <span>Tambah Data Baru</span>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center text-xl shrink-0 border border-blue-100/30">
                    <i class="bi bi-database"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-800 leading-tight">{{ $pendapatans->count() }}</h3>
                    <p class="text-xs font-medium text-slate-400 mt-0.5">Total Entri Data</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-500 flex items-center justify-center text-xl shrink-0 border border-indigo-100/30">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <div>
                    <h3 class="text-xl font-extrabold text-slate-800 leading-tight">Rp
                        {{ number_format($pendapatans->avg('pendapatan'), 0, ',', '.') }}</h3>
                    <p class="text-xs font-medium text-slate-400 mt-0.5">Rata-rata Omzet</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-xl shrink-0 border border-amber-100/30">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div>
                    <h3 class="text-base font-extrabold text-slate-800 leading-tight">Terintegrasi</h3>
                    <p class="text-xs font-medium text-slate-400 mt-0.5">Sinkronisasi Model LSTM</p>
                </div>
            </div>
        </div>

        <div
            class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl p-6 text-white shadow-sm flex items-center justify-between relative overflow-hidden">
            <div class="z-10">
                <p class="text-xs font-bold text-emerald-100 uppercase tracking-wider">Aset Akumulasi Pendapatan</p>
                <h2 class="text-3xl sm:text-4xl font-black mt-1 tracking-tight">
                    Rp {{ number_format($pendapatans->sum('pendapatan'), 0, ',', '.') }}
                </h2>
            </div>
            <div
                class="w-14 h-14 rounded-xl bg-white/10 flex items-center justify-center text-2xl text-white/90 z-10 shrink-0 border border-white/10">
                <i class="bi bi-cash-stack"></i>
            </div>
            <div class="absolute -right-6 -bottom-6 w-28 h-28 bg-white/5 rounded-full pointer-events-none"></div>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 space-y-4">
            <form method="GET" action="{{ route('pendapatan.index') }}"
                class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wide mb-1.5">Tanggal
                        Awal</label>
                    <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:ring-2 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-colors">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wide mb-1.5">Tanggal
                        Akhir</label>
                    <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:ring-2 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-colors">
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit"
                        class="flex-1 inline-flex items-center justify-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-xs font-bold transition-colors border-0 cursor-pointer h-[34px]">
                        <i class="bi bi-search"></i>
                        <span>Filter</span>
                    </button>
                    <a href="{{ route('pendapatan.index') }}"
                        class="flex-1 inline-flex items-center justify-center bg-slate-100 hover:bg-slate-200 text-slate-600 px-4 py-2 rounded-xl text-xs font-bold transition-colors no-underline text-center h-[34px]">
                        <span>Reset</span>
                    </a>
                </div>
            </form>

            <div class="border-t border-slate-100/70 my-3"></div>

            <div class="max-w-xs relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                    <i class="bi bi-search text-xs"></i>
                </div>
                <input type="text" id="searchTable"
                    class="block w-full pl-8 pr-4 py-2.5 bg-slate-50 border border-slate-200 text-xs rounded-xl focus:ring-2 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all duration-200 placeholder:text-slate-400"
                    placeholder="Cari data di tabel...">
            </div>
        </div>

        @if (request('tanggal_awal') && request('tanggal_akhir'))
            <div class="flex items-center gap-2.5 p-3.5 text-xs font-medium text-blue-800 border border-blue-100 rounded-xl bg-blue-50/70"
                role="alert">
                <i class="bi bi-info-circle-fill text-blue-500 text-sm"></i>
                <div>
                    Menampilkan data dari <strong
                        class="text-blue-950">{{ \Carbon\Carbon::parse(request('tanggal_awal'))->translatedFormat('d M Y') }}</strong>
                    sampai <strong
                        class="text-blue-950">{{ \Carbon\Carbon::parse(request('tanggal_akhir'))->translatedFormat('d M Y') }}</strong>
                </div>
            </div>
        @endif

        @if (session('success'))
            <div class="flex items-center gap-2.5 p-3.5 text-xs font-medium text-emerald-800 border border-emerald-100 rounded-xl bg-emerald-50"
                role="alert">
                <i class="bi bi-check-circle-fill text-emerald-500 text-sm"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden" x-data="{ modalEditId: null }">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-50 border-b border-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider">
                            <th class="px-6 py-4 text-center w-20">No</th>
                            <th class="px-6 py-4">Tanggal Transaksi</th>
                            <th class="px-6 py-4">Nominal Pendapatan</th>
                            <th class="px-6 py-4">Keterangan Catatan</th>
                            <th class="px-6 py-4 text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                        @foreach ($pendapatans as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-center font-bold text-slate-400">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 font-semibold text-slate-700">
                                    {{ $item->tanggal->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold text-emerald-600 text-sm">
                                        Rp {{ number_format($item->pendapatan, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-500 max-w-xs truncate">{{ $item->keterangan ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-1">
                                        <button @click="modalEditId = {{ $item->id }}"
                                            class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors border-0 cursor-pointer bg-transparent">
                                            <i class="bi bi-pencil-square text-sm"></i>
                                        </button>

                                        <form action="/pendapatan/{{ $item->id }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Hapus data pendapatan harian ini?')"
                                                class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors border-0 cursor-pointer bg-transparent">
                                                <i class="bi bi-trash text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <div x-show="modalEditId === {{ $item->id }}"
                                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                                style="display: none;" x-transition>

                                <div class="relative w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-100"
                                    @click.away="modalEditId = null">
                                    <form action="/pendapatan/{{ $item->id }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                                            <h3 class="text-xs font-bold text-slate-800 flex items-center gap-2">
                                                <i class="bi bi-pencil-square text-amber-500"></i> Ubah Data Pendapatan
                                            </h3>
                                            <button type="button" @click="modalEditId = null"
                                                class="text-slate-400 hover:text-slate-600 border-0 bg-transparent cursor-pointer"><i
                                                    class="bi bi-x-lg"></i></button>
                                        </div>

                                        <div class="p-6 space-y-4 text-left">
                                            <div>
                                                <label
                                                    class="block text-[11px] font-bold text-slate-400 uppercase tracking-wide mb-1.5">Tanggal</label>
                                                <input type="date" name="tanggal"
                                                    value="{{ $item->tanggal->format('Y-m-d') }}" required
                                                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none">
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-[11px] font-bold text-slate-400 uppercase tracking-wide mb-1.5">Nominal
                                                    Pendapatan (Rp)</label>
                                                <input type="number" name="pendapatan" value="{{ $item->pendapatan }}"
                                                    required
                                                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none">
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-[11px] font-bold text-slate-400 uppercase tracking-wide mb-1.5">Keterangan
                                                    Catatan</label>
                                                <textarea name="keterangan" rows="3"
                                                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none placeholder:text-slate-400">{{ $item->keterangan }}</textarea>
                                            </div>
                                        </div>

                                        <div
                                            class="flex items-center justify-end gap-2 px-6 py-3.5 bg-slate-50 border-t border-slate-100 rounded-b-2xl">
                                            <button type="button" @click="modalEditId = null"
                                                class="px-4 py-2 text-xs font-bold text-slate-500 hover:bg-slate-200 rounded-xl transition-colors cursor-pointer border-0">Batal</button>
                                            <button type="submit"
                                                class="px-4 py-2 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-md transition-colors cursor-pointer border-0">Simpan
                                                Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="modalTambah"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
            style="display: none;" x-transition>

            <div class="relative w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-100"
                @click.away="modalTambah = false">
                <form action="/pendapatan" method="POST">
                    @csrf

                    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                        <h3 class="text-xs font-bold text-slate-800 flex items-center gap-2">
                            <i class="bi bi-plus-circle text-emerald-500"></i> Tambah Catatan Omzet Baru
                        </h3>
                        <button type="button" @click="modalTambah = false"
                            class="text-slate-400 hover:text-slate-600 border-0 bg-transparent cursor-pointer"><i
                                class="bi bi-x-lg"></i></button>
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <label
                                class="block text-[11px] font-bold text-slate-400 uppercase tracking-wide mb-1.5">Tanggal
                                Penjualan</label>
                            <input type="date" name="tanggal" required
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wide mb-1.5">Total
                                Pendapatan Bersih (Rp)</label>
                            <input type="number" name="pendapatan" placeholder="Contoh: 1250000" required
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none placeholder:text-slate-400">
                        </div>
                        <div>
                            <label
                                class="block text-[11px] font-bold text-slate-400 uppercase tracking-wide mb-1.5">Keterangan
                                Catatan Toko</label>
                            <textarea name="keterangan" rows="3"
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none placeholder:text-slate-400"
                                placeholder="Contoh: Pembelian rokok grosir meningkat pesat..."></textarea>
                        </div>
                    </div>

                    <div
                        class="flex items-center justify-end gap-2 px-6 py-3.5 bg-slate-50 border-t border-slate-100 rounded-b-2xl">
                        <button type="button" @click="modalTambah = false"
                            class="px-4 py-2 text-xs font-bold text-slate-500 hover:bg-slate-200 rounded-xl transition-colors cursor-pointer border-0">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-md transition-colors cursor-pointer border-0">Simpan
                            Catatan</button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="modalImport"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
            style="display: none;" x-transition>

            <div class="relative w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-100"
                @click.away="modalImport = false">
                <form action="{{ route('pendapatan.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                        <h3 class="text-xs font-bold text-slate-800 flex items-center gap-2">
                            <i class="bi bi-file-earmark-excel text-emerald-500"></i> Import File Dataset Excel/CSV
                        </h3>
                        <button type="button" @click="modalImport = false"
                            class="text-slate-400 hover:text-slate-600 border-0 bg-transparent cursor-pointer"><i
                                class="bi bi-x-lg"></i></button>
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wide mb-1.5">Pilih
                                File Dokumen</label>
                            <input type="file" name="file" required
                                class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-200 p-2 rounded-xl bg-slate-50">
                            <span class="block text-[10px] text-slate-400 mt-2 leading-relaxed">
                                <i class="bi bi-info-circle"></i> Pastikan struktur urutan kolom di dalam file sesuai
                                aturan: <strong>tanggal, pendapatan, keterangan</strong>.
                            </span>
                        </div>
                    </div>

                    <div
                        class="flex items-center justify-end gap-2 px-6 py-3.5 bg-slate-50 border-t border-slate-100 rounded-b-2xl">
                        <button type="button" @click="modalImport = false"
                            class="px-4 py-2 text-xs font-bold text-slate-500 hover:bg-slate-200 rounded-xl transition-colors cursor-pointer border-0">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-md transition-colors cursor-pointer border-0">Proses
                            Import</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('searchTable').addEventListener('keyup', function() {
            let value = this.value.toLowerCase();
            document.querySelectorAll('tbody tr').forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
            });
        });
    </script>
@endsection

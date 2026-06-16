@extends('layouts.app')

@section('title', 'Profil')

@section('content')
    <div class="space-y-6">

        <!-- SEKTOR ATAS: JUDUL HALAMAN -->
        <div>
            <h1 class="text-xl font-bold text-slate-800 tracking-tight">Profil Pengguna</h1>
            <p class="text-xs text-slate-400 mt-0.5">Informasi akun personal dan konfigurasi proteksi keamanan sandi pengguna
            </p>
        </div>

        <!-- PANEL NOTIFIKASI BERHASIL / KESALAHAN VALIDASI FORM -->
        @if (session('success'))
            <div class="flex items-center justify-between p-3.5 text-xs font-semibold text-emerald-800 border border-emerald-100 rounded-xl bg-emerald-50"
                role="alert">
                <div class="flex items-center gap-2.5">
                    <i class="bi bi-check-circle-fill text-emerald-500 text-sm"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button onclick="this.parentElement.remove()"
                    class="text-emerald-500 hover:text-emerald-700 bg-transparent border-0 cursor-pointer"><i
                        class="bi bi-x-lg"></i></button>
            </div>
        @endif

        @if (session('error'))
            <div class="flex items-center justify-between p-3.5 text-xs font-semibold text-rose-800 border border-rose-100 rounded-xl bg-rose-50"
                role="alert">
                <div class="flex items-center gap-2.5">
                    <i class="bi bi-exclamation-circle-fill text-rose-500 text-sm"></i>
                    <div>{{ session('error') }}</div>
                </div>
                <button onclick="this.parentElement.remove()"
                    class="text-rose-500 hover:text-rose-700 bg-transparent border-0 cursor-pointer"><i
                        class="bi bi-x-lg"></i></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 text-xs font-semibold text-rose-800 border border-rose-100 rounded-xl bg-rose-50">
                <div class="flex items-center gap-2 font-bold mb-2 text-rose-900">
                    <i class="bi bi-exclamation-triangle-fill text-sm"></i>
                    <span>Terdapat kesalahan pada isian form:</span>
                </div>
                <ul class="list-disc ml-5 space-y-1 text-rose-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- GRID STRUKTUR LAYOUT UTAMA -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            <!-- KARTU INFORMASI AKUN (SISI KIRI) -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex flex-col justify-between">
                <div class="flex flex-col items-center text-center pb-5 border-b border-slate-100">
                    <!-- Avatar Representatif Modern -->
                    <div
                        class="w-20 h-20 rounded-full bg-slate-50 border border-slate-100 text-slate-400 flex items-center justify-center text-3xl shadow-inner relative">
                        <i class="bi bi-person"></i>
                        <span
                            class="absolute bottom-0 right-0 w-4 h-4 rounded-full bg-emerald-500 border-2 border-white"></span>
                    </div>
                    <h3 class="mt-4 text-base font-bold text-slate-800 tracking-tight">{{ auth()->user()->name }}</h3>
                    <p class="text-xs font-medium text-slate-400 mt-0.5">{{ auth()->user()->email }}</p>
                </div>

                <!-- List Atribut Pengguna (Gaya Row List Bersih) -->
                <div class="mt-5 space-y-4 text-xs">
                    <div class="flex justify-between items-center py-1.5 border-b border-slate-50">
                        <span class="text-slate-400 font-bold uppercase tracking-wide">Tingkat Otoritas</span>
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded bg-purple-50 text-purple-700 font-bold uppercase tracking-wider border border-purple-100/50">
                            {{ auth()->user()->role }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center py-1.5 border-b border-slate-50">
                        <span class="text-slate-400 font-bold uppercase tracking-wide">Status Akses</span>
                        <span
                            class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-bold border border-emerald-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            <span class="capitalize">{{ auth()->user()->status }}</span>
                        </span>
                    </div>

                    <div class="flex justify-between items-center py-1.5">
                        <span class="text-slate-400 font-bold uppercase tracking-wide">Bergabung Sejak</span>
                        <span class="font-semibold text-slate-700">
                            {{ auth()->user()->created_at->translatedFormat('d F Y') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- FORM PENGATURAN DATA & SANDI (SISI KANAN - 2 KOLOM) -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Blok Form 1: Edit Biodata Profil -->
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <h4 class="text-sm font-bold text-slate-800 mb-5 flex items-center gap-2">
                        <i class="bi bi-person-gear text-emerald-600"></i> Informasi Data Diri
                    </h4>

                    <form action="{{ route('profil.update') }}" method="POST">
                        @csrf
                        @if (in_array('PUT', ['PUT', 'PATCH']))
                            @method('PUT')
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-slate-400 uppercase tracking-wide mb-1.5">Nama
                                    Lengkap</label>
                                <input type="text" name="name" value="{{ auth()->user()->name }}" required
                                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:ring-2 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-colors">
                            </div>

                            <div>
                                <label
                                    class="block text-[11px] font-bold text-slate-400 uppercase tracking-wide mb-1.5">Alamat
                                    Email</label>
                                <input type="email" name="email" value="{{ auth()->user()->email }}" required
                                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:ring-2 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-colors">
                            </div>
                        </div>

                        <div class="mt-5 flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center justify-center bg-slate-800 hover:bg-slate-900 text-white px-4 py-2 rounded-xl text-xs font-bold shadow-sm border-0 cursor-pointer transition-colors">
                                <span>Simpan Perubahan</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Blok Form 2: Ubah Keamanan Sandi Akun -->
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <h4 class="text-sm font-bold text-slate-800 mb-5 flex items-center gap-2">
                        <i class="bi bi-shield-lock text-emerald-600"></i> Perbarui Autentikasi Sandi
                    </h4>

                    <form action="{{ route('profil.password') }}" method="POST" class="space-y-4">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-slate-400 uppercase tracking-wide mb-1.5">Password
                                    Lama</label>
                                <input type="password" name="current_password" required
                                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-colors">
                            </div>

                            <div>
                                <label
                                    class="block text-[11px] font-bold text-slate-400 uppercase tracking-wide mb-1.5">Password
                                    Baru</label>
                                <input type="password" name="password" required
                                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-colors">
                            </div>

                            <div>
                                <label
                                    class="block text-[11px] font-bold text-slate-400 uppercase tracking-wide mb-1.5">Konfirmasi
                                    Sandi Baru</label>
                                <input type="password" name="password_confirmation" required
                                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-colors">
                            </div>
                        </div>

                        <div class="mt-5 flex justify-end pt-2">
                            <button type="submit"
                                class="inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-xs font-bold shadow-md shadow-emerald-900/10 border-0 cursor-pointer transition-all">
                                <span>Perbarui Password</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>

    </div>
@endsection

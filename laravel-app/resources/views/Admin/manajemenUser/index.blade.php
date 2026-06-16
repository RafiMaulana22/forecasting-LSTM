@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">Manajemen User</h1>
                <p class="text-xs text-slate-400 mt-0.5">Kelola hak akses kredensial akun pengguna sistem forecasting KasirKu
                    AI</p>
            </div>
            <button
                onclick="document.getElementById('modalTambah').classList.remove('hidden'); document.getElementById('modalTambah').classList.add('flex')"
                class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-xl text-xs font-bold shadow-md shadow-emerald-900/10 transition-all duration-150 cursor-pointer border-0">
                <i class="bi bi-person-plus text-sm"></i>
                <span>Tambah Admin Baru</span>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center text-xl shrink-0 border border-blue-100/30">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight leading-tight">{{ $users->count() }}
                    </h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Total Pengguna</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl shrink-0 border border-emerald-100/30">
                    <i class="bi bi-person-check"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-emerald-600 tracking-tight leading-tight">
                        {{ $users->where('status', 'aktif')->count() }}
                    </h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Akun Status Aktif</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center text-xl shrink-0 border border-rose-100/30">
                    <i class="bi bi-person-x"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-extrabold text-rose-600 tracking-tight leading-tight">
                        {{ $users->where('status', 'nonaktif')->count() }}
                    </h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Akun Status Nonaktif</p>
                </div>
            </div>
        </div>

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
                    <i class="bi bi-exclamation-triangle-fill text-rose-500 text-sm"></i>
                    <div>{{ session('error') }}</div>
                </div>
                <button onclick="this.parentElement.remove()"
                    class="text-rose-500 hover:text-rose-700 bg-transparent border-0 cursor-pointer"><i
                        class="bi bi-x-lg"></i></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 text-xs font-semibold text-rose-800 border border-rose-100 rounded-xl bg-rose-50">
                <ul class="list-disc ml-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-5 border-b border-slate-100">
                <h4 class="text-sm font-bold text-slate-800">Daftar Akun Operator</h4>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-50 border-b border-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-wider">
                            <th class="px-6 py-4 text-center w-20">No</th>
                            <th class="px-6 py-4">Nama Pengguna</th>
                            <th class="px-6 py-4">Alamat Email</th>
                            <th class="px-6 py-4">Tingkatan Hak Akses (Role)</th>
                            <th class="px-6 py-4">Status Akun</th>
                            <th class="px-6 py-4">Terdaftar Sejak</th>
                            <th class="px-6 py-4 text-center w-64">Opsi Manajemen</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                        @forelse($users as $user)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-center font-bold text-slate-400 bg-slate-50/10">
                                    {{ $loop->iteration }}</td>
                                <td class="px-6 py-4 font-bold text-slate-800">{{ $user->name }}</td>
                                <td class="px-6 py-4 font-medium text-slate-500">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded bg-purple-50 text-purple-700 text-[10px] font-bold uppercase tracking-wider border border-purple-100/50">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($user->status == 'aktif')
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            <span>Aktif</span>
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-700 text-[10px] font-bold border border-rose-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                            <span>Nonaktif</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-slate-400 font-medium">
                                    {{ $user->created_at->translatedFormat('d M Y') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <button
                                            onclick="openEditModal('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}')"
                                            class="px-2.5 py-1.5 bg-white hover:bg-slate-50 text-amber-600 rounded-lg text-[11px] font-bold border border-slate-200">
                                            Edit
                                        </button>

                                        <button onclick="openResetModal('{{ $user->id }}', '{{ $user->name }}')"
                                            class="px-2.5 py-1.5 bg-white hover:bg-slate-50 text-blue-600 rounded-lg text-[11px] font-bold border border-slate-200 transition-colors shadow-sm cursor-pointer">
                                            Reset Sandi
                                        </button>

                                        <form action="{{ route('users.status', $user->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="px-2.5 py-1.5 rounded-lg text-[11px] font-bold text-white transition-colors cursor-pointer border-0 shadow-sm {{ $user->status == 'aktif' ? 'bg-rose-600 hover:bg-rose-700' : 'bg-emerald-600 hover:bg-emerald-700' }}">
                                                {{ $user->status == 'aktif' ? 'Blokir' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-12">
                                    <div
                                        class="w-11 h-11 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 mx-auto mb-3 text-lg border border-slate-100">
                                        <i class="bi bi-person-gear"></i>
                                    </div>
                                    <p class="text-xs text-slate-400 font-medium">Belum ada akun user terdaftar di pangkalan
                                        data.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div id="modalTambah"
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden z-50 items-center justify-center p-4">
            <div class="relative w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-100">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                    <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i class="bi bi-person-plus text-emerald-500"></i> Daftarkan Admin Baru
                    </h3>
                    <button
                        onclick="document.getElementById('modalTambah').classList.add('hidden'); document.getElementById('modalTambah').classList.remove('flex')"
                        class="text-slate-400 hover:text-slate-600 border-0 bg-transparent cursor-pointer"><i
                            class="bi bi-x-lg"></i></button>
                </div>

                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="p-6 space-y-4 text-left">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wide mb-1.5">Nama
                                Lengkap</label>
                            <input type="text" name="name" placeholder="Contoh: Rafi Mahasiswa" required
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:ring-2 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all placeholder:text-slate-400">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wide mb-1.5">Alamat
                                Email Resmi</label>
                            <input type="email" name="email" placeholder="admin@kasirku.id" required
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:ring-2 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all placeholder:text-slate-400">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wide mb-1.5">Kata
                                Sandi Akun</label>
                            <input type="password" name="password" required
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wide mb-1.5">Ulangi
                                Konfirmasi Sandi</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all">
                        </div>

                        <input type="hidden" name="role" value="admin">
                        <input type="hidden" name="status" value="aktif">
                    </div>

                    <div
                        class="flex items-center justify-end gap-2 px-6 py-3.5 bg-slate-50 border-t border-slate-100 rounded-b-2xl">
                        <button type="button"
                            onclick="document.getElementById('modalTambah').classList.add('hidden'); document.getElementById('modalTambah').classList.remove('flex')"
                            class="px-4 py-2 text-xs font-bold text-slate-500 hover:bg-slate-200 rounded-xl transition-colors cursor-pointer border-0">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-md transition-colors cursor-pointer border-0">Simpan
                            Akun</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="modalEdit"
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden z-50 items-center justify-center p-4">
            <div class="relative w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-100">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                    <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i class="bi bi-pencil-square text-amber-500"></i> Ubah Biodata Pengguna
                    </h3>
                    <button type="button"
                        onclick="document.getElementById('modalEdit').classList.add('hidden'); document.getElementById('modalEdit').classList.remove('flex')"
                        class="text-slate-400 hover:text-slate-600 border-0 bg-transparent cursor-pointer"><i
                            class="bi bi-x-lg"></i></button>
                </div>

                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="edit_id">

                    <div class="p-6 space-y-4 text-left">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wide mb-1.5">Nama
                                Perubahan</label>
                            <input type="text" id="edit_name" name="name" required
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:ring-2 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wide mb-1.5">Alamat
                                Email Perubahan</label>
                            <input type="email" id="edit_email" name="email" required
                                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:ring-2 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none">
                        </div>
                    </div>

                    <div
                        class="flex items-center justify-end gap-2 px-6 py-3.5 bg-slate-50 border-t border-slate-100 rounded-b-2xl">
                        <button type="button"
                            onclick="document.getElementById('modalEdit').classList.add('hidden'); document.getElementById('modalEdit').classList.remove('flex')"
                            class="px-4 py-2 text-xs font-bold text-slate-500 hover:bg-slate-200 rounded-xl transition-colors cursor-pointer border-0">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 text-xs font-bold text-white bg-amber-500 hover:bg-amber-600 rounded-xl shadow-md transition-colors cursor-pointer border-0">Update
                            Data</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="resetModal"
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm border border-slate-100 overflow-hidden">
                <div class="p-6 text-center space-y-3">
                    <div
                        class="w-12 h-12 bg-rose-50 text-rose-500 border border-rose-100 rounded-full flex items-center justify-center text-xl mx-auto shadow-sm">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">Otorisasi Reset Sandi</h3>
                        <p class="text-xs text-slate-400 mt-1 leading-relaxed">
                            Apakah Anda yakin ingin mengatur ulang sandi masuk default untuk pengguna <span
                                id="resetUserName" class="font-bold text-slate-800 underline"></span>?
                        </p>
                    </div>
                </div>

                <form id="resetForm" method="POST">
                    @csrf
                    <div class="flex items-center justify-end gap-2 px-6 py-3.5 bg-slate-50 border-t border-slate-100">
                        <button type="button" onclick="closeResetModal()"
                            class="px-4 py-2 text-xs font-bold text-slate-500 hover:bg-slate-200 rounded-xl transition-colors cursor-pointer border-0">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-md shadow-rose-100 transition-colors cursor-pointer border-0">Ya,
                            Reset Sekarang</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        function openEditModal(id, name, email) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;

            document.getElementById('editForm').action =
                `/manajemen-user/${id}`;

            document.getElementById('modalEdit').classList.remove('hidden');
            document.getElementById('modalEdit').classList.add('flex');
        }

        function closeEditModal() {
            document.getElementById('modalEdit').classList.add('hidden');
            document.getElementById('modalEdit').classList.remove('flex');
        }

        function openResetModal(id, name) {
            document.getElementById('resetUserName').innerText = name;

            document.getElementById('resetForm').action =
                `/manajemen-user/${id}/reset-password`;

            document.getElementById('resetModal').classList.remove('hidden');
            document.getElementById('resetModal').classList.add('flex');
        }

        function closeResetModal() {
            document.getElementById('resetModal').classList.add('hidden');
            document.getElementById('resetModal').classList.remove('flex');
        }

        function openTambahModal() {
            document.getElementById('modalTambah').classList.remove('hidden');
            document.getElementById('modalTambah').classList.add('flex');
        }

        function closeTambahModal() {
            document.getElementById('modalTambah').classList.add('hidden');
            document.getElementById('modalTambah').classList.remove('flex');
        }
    </script>
@endsection

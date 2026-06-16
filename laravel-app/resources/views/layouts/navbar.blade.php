<div class="w-full flex flex-col sm:flex-row sm:items-center sm:justify-between px-6 py-4 bg-white gap-4">

    <div>
        <h1 class="text-xl font-bold text-slate-800 tracking-tight">
            @yield('title', 'Dashboard')
        </h1>
        <p class="text-xs text-slate-400 mt-0.5 flex items-center gap-1">
            <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Sistem Forecasting Pendapatan Warung Madura (LSTM)
        </p>
    </div>

    <div class="flex items-center justify-between sm:justify-end gap-4">

        <div class="hidden xs:block text-right border-r border-slate-100 pr-4">
            <div class="text-sm font-semibold text-slate-800 capitalize">
                {{ now()->translatedFormat('l') }}
            </div>
            <div class="text-xs text-slate-400">
                {{ now()->translatedFormat('d F Y') }}
            </div>
        </div>

        <div class="relative" x-data="{ open: false }" @click.away="open = false">

            <button @click="open = !open"
                class="flex items-center gap-3 p-1.5 pr-3 hover:bg-slate-50 rounded-xl transition-all duration-200 text-left cursor-pointer focus:outline-none">

                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=10b981&color=fff&bold=true"
                    alt="User Avatar" class="w-10 h-10 rounded-xl object-cover ring-2 ring-emerald-500/10">

                <div class="hidden sm:block">
                    <div class="text-sm font-semibold text-slate-800 leading-tight">
                        {{ Auth::user()->name }}
                    </div>
                    <div class="text-[11px] text-slate-400 font-medium mt-0.5">
                        {{ Auth::user()->role == 'super_admin' ? 'Super Admin' : 'Admin' }}
                    </div>
                </div>

                <i class="bi bi-chevron-down text-xs text-slate-400 transition-transform duration-200"
                    :class="open ? 'rotate-180' : ''"></i>
            </button>

            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl shadow-slate-200/80 border border-slate-100 py-2 z-30"
                style="display: none;">

                <a href="/profil"
                    class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 hover:text-emerald-600 transition-colors">
                    <i class="bi bi-person text-base text-slate-400"></i>
                    <span>Profil</span>
                </a>

                <div class="my-1.5 border-t border-slate-100"></div>

                <a href="/logout"
                    class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-rose-600 hover:bg-rose-50 transition-colors font-medium">
                    <i class="bi bi-box-arrow-right text-base"></i>
                    <span>Keluar Aplikasi</span>
                </a>
            </div>

        </div>

    </div>
</div>

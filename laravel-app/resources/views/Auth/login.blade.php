<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Smart Forecaster Warung Madura</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body
    class="h-full flex items-center justify-center font-sans antialiased selection:bg-emerald-500 selection:text-white">

    <div class="w-full max-w-md p-6 sm:p-8">

        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-lg shadow-emerald-200 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                    stroke="currentColor" class="w-7 h-7">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                </svg>
            </div>

            <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                KasirKu <span class="text-emerald-600">AI</span>
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Sistem Peramalan Pendapatan 7 Hari ke Depan
            </p>
        </div>

        <div class="bg-white rounded-3xl shadow-xl shadow-slate-100 border border-slate-100 p-8">

            <div class="mb-6">
                <h3 class="text-xl font-semibold text-slate-800">Selamat Datang</h3>
                <p class="text-xs text-slate-400 mt-0.5">Silakan masuk untuk mengakses dasbor analisis toko Anda</p>
            </div>

            @if (session('error'))
                <div class="mb-5 flex items-center gap-3 p-4 text-sm text-red-800 border border-red-100 rounded-2xl bg-red-50"
                    role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-5 h-5 text-red-500 shrink-0">
                        <path fill-rule="evenodd"
                            d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9.00a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z"
                            clip-rule="evenodd" />
                    </svg>
                    <div>
                        <span class="font-medium">Gagal masuk!</span> {{ session('error') }}
                    </div>
                </div>
            @endif

            <form action="{{ route('login.proses') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email Toko</label>
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <input type="email" id="email" name="email" required
                            class="block w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white transition-all duration-200 outline-none placeholder:text-slate-400"
                            placeholder="admin@warungmadura.com">
                    </div>
                </div>

                <div x-data="{ showPassword: false }">
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Password
                    </label>

                    <div class="relative">

                        <!-- Icon Lock -->
                        <div
                            class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>

                        <!-- Input Password -->
                        <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required
                            class="block w-full pl-11 pr-12 py-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white transition-all duration-200 outline-none placeholder:text-slate-400"
                            placeholder="••••••••">

                        <!-- Toggle Eye -->
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-emerald-600 transition">

                            <!-- Mata terbuka -->
                            <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12 18 19.5 12 19.5 2.25 12 2.25 12z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 15.75A3.75 3.75 0 1012 8.25a3.75 3.75 0 000 7.5z" />
                            </svg>

                            <!-- Mata tertutup -->
                            <svg x-show="showPassword" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.584 10.587A2.25 2.25 0 0013.5 13.5" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.88 5.09A9.77 9.77 0 0112 4.5c6 0 9.75 7.5 9.75 7.5a17.6 17.6 0 01-3.214 4.433M6.228 6.228A17.36 17.36 0 002.25 12s3.75 7.5 9.75 7.5a9.77 9.77 0 004.062-.877" />
                            </svg>

                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 font-semibold rounded-xl text-sm px-5 py-3.5 text-center shadow-md shadow-emerald-200 active:scale-[0.98] transition-all duration-150 mt-2 cursor-pointer">
                    <span>Masuk ke Sistem</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </button>

            </form>

        </div>

        <p class="text-center text-xs text-slate-400 mt-8">
            &copy; 2026 Warung Madura Digital. All rights reserved.
        </p>

    </div>

</body>

</html>

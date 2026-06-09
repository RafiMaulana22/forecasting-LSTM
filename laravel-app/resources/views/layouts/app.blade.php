<!DOCTYPE html>
<html lang="id" class="h-full bg-[#f8fafc]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Smart Forecasting Warung Madura')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="h-full font-sans antialiased bg-[#f1f5f9] text-slate-800">

    <div class="min-h-screen flex bg-[#f8fafc]">

        <aside
            class="fixed inset-y-0 left-0 z-20 w-[280px] bg-gradient-to-b from-slate-900 via-slate-950 to-slate-950 text-slate-300 hidden md:flex flex-col border-r border-slate-800/40">
            @include('layouts.sidebar')
        </aside>

        <div class="flex-1 flex flex-col pl-0 md:pl-[280px] min-h-screen bg-[#f8fafc]">

            <header class="sticky top-0 z-10 bg-white border-b border-slate-100 shadow-sm shadow-slate-100/40">
                @include('layouts.navbar')
            </header>

            <main class="flex-1 p-6 md:p-8 bg-[#f8fafc]">
                @yield('content')
            </main>

        </div>

    </div>

    @yield('scripts')

</body>

</html>

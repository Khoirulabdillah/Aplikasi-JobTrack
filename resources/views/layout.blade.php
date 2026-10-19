<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'JobTrack')</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-slate-100 text-slate-800 antialiased transition-colors duration-200">
    <div class="flex min-h-screen">
        <aside class="hidden w-64 flex-col border-r border-slate-200 bg-white lg:sticky lg:top-0 lg:h-screen lg:self-start lg:flex">
            <div class="flex items-center gap-3 border-b border-slate-200 px-6 py-5">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-600 via-blue-600 to-sky-500 shadow-lg shadow-indigo-500/20 ring-4 ring-indigo-100">
                    <svg viewBox="0 0 24 24" class="h-6 w-6 text-white" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M9 7V5.75A1.75 1.75 0 0 1 10.75 4h2.5A1.75 1.75 0 0 1 15 5.75V7"/>
                        <path d="M4 8.75A2.75 2.75 0 0 1 6.75 6h10.5A2.75 2.75 0 0 1 20 8.75v7.5A2.75 2.75 0 0 1 17.25 19H6.75A2.75 2.75 0 0 1 4 16.25z"/>
                        <path d="M9 12h6"/>
                    </svg>
                </div>
                <div>
                    <p class="text-lg font-bold tracking-tight text-slate-900">JobTrack</p>
                    <p class="text-[11px] font-medium uppercase tracking-[0.18em] text-slate-500">Career Hub</p>
                </div>
            </div>

            <nav class="flex-1 space-y-2 p-4">
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }} flex items-center gap-3 rounded-xl border border-transparent px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                    <span class="flex h-5 w-5 items-center justify-center">
                        <img src="{{ asset('icon/dashboard.png') }}" alt="Dashboard" class="h-5 w-5 object-contain" />
                    </span>
                    Dashboard
                </a>
                <a href="{{ route('applications.index') }}" class="sidebar-link {{ request()->routeIs('applications.*') ? 'active' : '' }} flex items-center gap-3 rounded-xl border border-transparent px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                    <span class="flex h-5 w-5 items-center justify-center">
                        <img src="{{ asset('icon/semua%20lamaran.png') }}" alt="Semua Lamaran" class="h-5 w-5 object-contain" />
                    </span>
                    Semua Lamaran
                </a>
                <a href="{{ route('applications.create') }}" class="sidebar-link {{ request()->routeIs('applications.create') ? 'active' : '' }} flex items-center gap-3 rounded-xl border border-transparent px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                    <span class="flex h-5 w-5 items-center justify-center">
                        <img src="{{ asset('icon/tambah%20lamaran.png') }}" alt="Tambah Lamaran" class="h-5 w-5 object-contain" />
                    </span>
                    Tambah Lamaran
                </a>
                <a href="{{ route('calendar') }}" class="sidebar-link {{ request()->routeIs('calendar') ? 'active' : '' }} flex items-center gap-3 rounded-xl border border-transparent px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                    <span class="flex h-5 w-5 items-center justify-center">
                        <img src="{{ asset('icon/kalender.png') }}" alt="Kalender" class="h-5 w-5 object-contain" />
                    </span>
                    Kalender dan Follow-up
                </a>
                <a href="{{ route('settings') }}" class="sidebar-link {{ request()->routeIs('settings') ? 'active' : '' }} flex items-center gap-3 rounded-xl border border-transparent px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                    <span class="flex h-5 w-5 items-center justify-center">
                        <img src="{{ asset('icon/settings.png') }}" alt="Pengaturan" class="h-5 w-5 object-contain" />
                    </span>
                    Pengaturan Aplikasi
                </a>
            </nav>
        </aside>

        <div class="flex-1">
            <header class="sticky top-0 z-10 border-b border-slate-200 bg-white/90 backdrop-blur">
                <div class="flex items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">@yield('page_title', 'Dashboard')</h1>
                    </div>
                    <div class="flex items-center gap-3">
                        <button id="themeToggle" type="button" aria-label="Toggle dark mode" aria-pressed="false" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-100">
                            <span id="themeToggleIcon" aria-hidden="true">🌙</span>
                            <span id="themeToggleLabel">Dark</span>
                        </button>
                        <a href="{{ route('applications.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500">
                            + Tambah Lamaran
                        </a>
                    </div>
                </div>
            </header>

            <main class="p-4 sm:p-6 lg:p-8">
                @if (session('success'))
                    <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <ul class="list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        const root = document.documentElement;
        const themeToggle = document.getElementById('themeToggle');
        const themeToggleIcon = document.getElementById('themeToggleIcon');
        const themeToggleLabel = document.getElementById('themeToggleLabel');

        const syncTheme = () => {
            const isDark = root.classList.contains('dark');
            themeToggleIcon.textContent = isDark ? '☀️' : '🌙';
            themeToggleLabel.textContent = isDark ? 'Light' : 'Dark';
            themeToggle?.setAttribute('aria-pressed', String(isDark));
        };

        const savedTheme = localStorage.getItem('jobtrack-theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        root.classList.toggle('dark', savedTheme ? savedTheme === 'dark' : prefersDark);

        syncTheme();

        themeToggle?.addEventListener('click', () => {
            const isDark = root.classList.toggle('dark');
            localStorage.setItem('jobtrack-theme', isDark ? 'dark' : 'light');
            syncTheme();
        });
    </script>
</body>
</html>

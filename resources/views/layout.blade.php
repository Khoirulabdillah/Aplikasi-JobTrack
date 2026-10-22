<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'JobTrack')</title>
    <script>
        (() => {
            const savedTheme = localStorage.getItem('jobtrack-theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            document.documentElement.classList.toggle('dark', savedTheme ? savedTheme === 'dark' : prefersDark);
        })();
    </script>
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

            <nav aria-label="Menu utama" class="flex-1 space-y-2 p-4">
                @include('partials.navigation')
            </nav>
        </aside>

        <div class="flex-1">
            <header class="sticky top-0 z-10 border-b border-slate-200 bg-white/90 backdrop-blur">
                <div class="relative px-4 py-3 sm:px-6 sm:py-4 lg:px-8">
                    <div class="flex items-center justify-between gap-3">
                        <h1 class="min-w-0 truncate text-xl font-bold text-slate-900">@yield('page_title', 'Dashboard')</h1>
                        <div class="flex shrink-0 items-center gap-2 sm:gap-3">
                            <button id="themeToggle" type="button" aria-label="Toggle dark mode" aria-pressed="false" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-2.5 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-100 sm:px-3">
                                <span id="themeToggleIcon" aria-hidden="true">🌙</span>
                                <span id="themeToggleLabel" class="hidden sm:inline">Dark</span>
                            </button>
                            <a href="{{ route('applications.create') }}" class="hidden items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 sm:inline-flex">
                                + Tambah Lamaran
                            </a>
                            <button id="mobileMenuToggle" type="button" aria-label="Buka menu navigasi" aria-expanded="false" aria-controls="mobileNavigation" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:bg-slate-50 lg:hidden">
                                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                                    <path d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <nav id="mobileNavigation" aria-label="Menu utama" class="hidden space-y-2 border-t border-slate-200 pt-3 lg:hidden">
                        @include('partials.navigation')
                    </nav>
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
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileNavigation = document.getElementById('mobileNavigation');
        let themeTransitionTimeout;

        const syncTheme = () => {
            const isDark = root.classList.contains('dark');
            themeToggleIcon.textContent = isDark ? '☀️' : '🌙';
            themeToggleLabel.textContent = isDark ? 'Light' : 'Dark';
            themeToggle?.setAttribute('aria-pressed', String(isDark));
        };

        syncTheme();

        themeToggle?.addEventListener('click', () => {
            document.body.classList.add('theme-transition');
            const isDark = root.classList.toggle('dark');
            localStorage.setItem('jobtrack-theme', isDark ? 'dark' : 'light');
            syncTheme();

            window.clearTimeout(themeTransitionTimeout);
            themeTransitionTimeout = window.setTimeout(() => {
                document.body.classList.remove('theme-transition');
            }, 350);
        });

        const closeMobileNavigation = () => {
            mobileNavigation?.classList.add('hidden');
            mobileMenuToggle?.setAttribute('aria-expanded', 'false');
            mobileMenuToggle?.setAttribute('aria-label', 'Buka menu navigasi');
        };

        mobileMenuToggle?.addEventListener('click', () => {
            const isExpanded = mobileMenuToggle.getAttribute('aria-expanded') === 'true';
            mobileNavigation?.classList.toggle('hidden', isExpanded);
            mobileMenuToggle.setAttribute('aria-expanded', String(!isExpanded));
            mobileMenuToggle.setAttribute('aria-label', isExpanded ? 'Buka menu navigasi' : 'Tutup menu navigasi');
        });

        mobileNavigation?.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', closeMobileNavigation);
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeMobileNavigation();
            }
        });

        const prefetchedNavigationUrls = new Set();
        const prefetchNavigationPage = (event) => {
            const link = event.target.closest('nav a[href]');

            if (
                !link ||
                link.origin !== window.location.origin ||
                link.href === window.location.href ||
                prefetchedNavigationUrls.has(link.href) ||
                navigator.connection?.saveData
            ) {
                return;
            }

            const prefetch = document.createElement('link');
            prefetch.rel = 'prefetch';
            prefetch.href = link.href;
            document.head.append(prefetch);
            prefetchedNavigationUrls.add(link.href);
        };

        document.addEventListener('pointerover', prefetchNavigationPage);
        document.addEventListener('focusin', prefetchNavigationPage);
    </script>
</body>
</html>

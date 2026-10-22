<a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }} flex items-center gap-3 rounded-xl border border-transparent px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
    <span class="flex h-5 w-5 items-center justify-center">
        <img src="{{ asset('icon/dashboard.png') }}" alt="" class="h-5 w-5 object-contain" />
    </span>
    Dashboard
</a>
<a href="{{ route('applications.index') }}" class="sidebar-link {{ request()->routeIs('applications.index', 'applications.show', 'applications.edit') ? 'active' : '' }} flex items-center gap-3 rounded-xl border border-transparent px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
    <span class="flex h-5 w-5 items-center justify-center">
        <img src="{{ asset('icon/semua%20lamaran.png') }}" alt="" class="h-5 w-5 object-contain" />
    </span>
    Semua Lamaran
</a>
<a href="{{ route('applications.create') }}" class="sidebar-link {{ request()->routeIs('applications.create') ? 'active' : '' }} flex items-center gap-3 rounded-xl border border-transparent px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
    <span class="flex h-5 w-5 items-center justify-center">
        <img src="{{ asset('icon/tambah%20lamaran.png') }}" alt="" class="h-5 w-5 object-contain" />
    </span>
    Tambah Lamaran
</a>
<a href="{{ route('calendar') }}" class="sidebar-link {{ request()->routeIs('calendar') ? 'active' : '' }} flex items-center gap-3 rounded-xl border border-transparent px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
    <span class="flex h-5 w-5 items-center justify-center">
        <img src="{{ asset('icon/kalender.png') }}" alt="" class="h-5 w-5 object-contain" />
    </span>
    Kalender dan Follow-up
</a>
<a href="{{ route('settings') }}" class="sidebar-link {{ request()->routeIs('settings') ? 'active' : '' }} flex items-center gap-3 rounded-xl border border-transparent px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
    <span class="flex h-5 w-5 items-center justify-center">
        <img src="{{ asset('icon/settings.png') }}" alt="" class="h-5 w-5 object-contain" />
    </span>
    Pengaturan Aplikasi
</a>

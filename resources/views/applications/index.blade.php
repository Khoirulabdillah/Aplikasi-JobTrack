@extends('layout')

@section('title', 'Semua Lamaran | JobTrack')
@section('page_title', 'Semua Lamaran')

@section('content')
<div class="space-y-6">
    <div class="card-surface rounded-2xl p-5">
        <form method="GET" action="{{ route('applications.index') }}" class="grid gap-4 md:grid-cols-2 xl:grid-cols-6">
            <div class="xl:col-span-2">
                <label class="mb-1 block text-sm font-medium text-slate-700">Pencarian</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari perusahaan atau posisi" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none">
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Status</label>
                <select name="status" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none">
                    <option value="">Semua</option>
                    @foreach (['Dikirim', 'Ditinjau', 'Diterima', 'Ditolak'] as $status)
                        <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Tipe</label>
                <select name="employment_type" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none">
                    <option value="">Semua</option>
                    @foreach (['Full-time','Part-time','Internship','Contract','Freelance'] as $type)
                        <option value="{{ $type }}" {{ request('employment_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Urutkan</label>
                <select name="sort" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none">
                    <option value="newest" {{ request('sort','newest') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Terlama</option>
                    <option value="company_asc" {{ request('sort') === 'company_asc' ? 'selected' : '' }}>Nama A-Z</option>
                    <option value="company_desc" {{ request('sort') === 'company_desc' ? 'selected' : '' }}>Nama Z-A</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="w-full rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white">Filter</button>
                <a href="{{ route('applications.index') }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-center text-sm font-medium text-slate-700">Reset</a>
            </div>
        </form>

        <div class="mt-4 grid gap-4 md:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Tanggal Mulai</label>
                <input type="date" name="date_from" form="filterForm" value="{{ request('date_from') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none">
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Tanggal Selesai</label>
                <input type="date" name="date_to" form="filterForm" value="{{ request('date_to') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none">
            </div>
        </div>
    </div>

    <div class="card-surface overflow-hidden rounded-2xl">
        <div class="divide-y divide-slate-200 lg:hidden">
            @forelse ($applications as $application)
                <article class="space-y-4 p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <h2 class="break-words font-semibold text-slate-900">{{ $application->company_name }}</h2>
                            <p class="mt-1 break-words text-sm text-slate-600">{{ $application->job_position }}</p>
                        </div>
                        <span class="status-badge status-{{ Str::lower($application->status) }} shrink-0">{{ $application->status }}</span>
                    </div>

                    <dl class="grid grid-cols-2 gap-x-3 gap-y-4 text-sm">
                        <div class="min-w-0">
                            <dt class="text-xs font-medium text-slate-500">Tanggal Melamar</dt>
                            <dd class="mt-1 break-words text-slate-700">{{ \Carbon\Carbon::parse($application->application_date)->translatedFormat('d M Y') }}</dd>
                        </div>
                        <div class="min-w-0">
                            <dt class="text-xs font-medium text-slate-500">Sumber</dt>
                            <dd class="mt-1 break-words text-slate-700">{{ $application->source }}</dd>
                        </div>
                        <div class="min-w-0">
                            <dt class="text-xs font-medium text-slate-500">Follow-up</dt>
                            <dd class="mt-1 break-words text-slate-700">{{ $application->follow_up_date ? \Carbon\Carbon::parse($application->follow_up_date)->translatedFormat('d M Y') : '-' }}</dd>
                        </div>
                    </dl>

                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('applications.show', $application) }}" class="flex-1 rounded-lg bg-indigo-100 px-3 py-2 text-center text-xs font-semibold text-blue-700">Detail</a>
                        <a href="{{ route('applications.edit', $application) }}" class="flex-1 rounded-lg bg-slate-200 px-3 py-2 text-center text-xs font-semibold text-blue-700">Edit</a>
                        <form action="{{ route('applications.destroy', $application) }}" method="POST" onsubmit="return confirm('Hapus lamaran ini?')" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full rounded-lg bg-red-100 px-3 py-2 text-xs font-semibold text-red-700">Hapus</button>
                        </form>
                    </div>
                </article>
            @empty
                <p class="px-4 py-10 text-center text-sm text-slate-500">Belum ada lamaran. Mulai dengan menambahkan lamaran baru.</p>
            @endforelse
        </div>

        <div class="hidden overflow-x-auto lg:block">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Nama Perusahaan</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Posisi</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Tanggal Melamar</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Sumber</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Status</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Follow-up</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse ($applications as $application)
                        <tr>
                            <td class="px-4 py-3 font-medium text-slate-800">{{ $application->company_name }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $application->job_position }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ \Carbon\Carbon::parse($application->application_date)->translatedFormat('d M Y') }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $application->source }}</td>
                            <td class="px-4 py-3"><span class="status-badge status-{{ Str::lower($application->status) }}">{{ $application->status }}</span></td>
                            <td class="px-4 py-3 text-slate-600">{{ $application->follow_up_date ? \Carbon\Carbon::parse($application->follow_up_date)->translatedFormat('d M Y') : '-' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('applications.show', $application) }}" class="rounded-lg bg-indigo-100 px-2 py-1 text-xs font-semibold text-blue-700">Detail</a>
                                    <a href="{{ route('applications.edit', $application) }}" class="rounded-lg bg-slate-200 px-2 py-1 text-xs font-semibold text-blue-700">Edit</a>
                                    <form action="{{ route('applications.destroy', $application) }}" method="POST" onsubmit="return confirm('Hapus lamaran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg bg-red-100 px-2 py-1 text-xs font-semibold text-red-700">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-slate-500">Belum ada lamaran. Mulai dengan menambahkan lamaran baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-200 px-4 py-3">
            {{ $applications->links() }}
        </div>
    </div>
</div>
@endsection

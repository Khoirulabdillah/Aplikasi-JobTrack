@extends('layout')

@section('title', 'Kalender Follow-up | JobTrack')
@section('page_title', 'Kalender dan Follow-up')

@section('content')
<div class="space-y-6">
    <div class="grid gap-6 lg:grid-cols-2">
        <div class="card-surface rounded-2xl p-5">
            <h2 class="mb-4 text-lg font-semibold text-slate-900">Follow-up Akan Datang</h2>
            @forelse ($upcoming as $application)
                <div class="mb-3 rounded-xl border border-slate-200 p-3">
                    <div class="flex items-center justify-between">
                        <p class="font-semibold text-slate-800">{{ $application->company_name }}</p>
                        <span class="status-badge status-{{ Str::lower($application->status) }}">{{ $application->status }}</span>
                    </div>
                    <p class="mt-1 text-sm text-slate-600">{{ $application->job_position }}</p>
                    <a href="{{ route('applications.show', $application) }}" class="mt-2 inline-block text-sm font-medium text-indigo-600">Lihat detail</a>
                    <p class="mt-2 text-xs font-medium text-indigo-700">{{ \Carbon\Carbon::parse($application->follow_up_date)->translatedFormat('d M Y') }}</p>
                </div>
            @empty
                <p class="text-sm text-slate-500">Tidak ada follow-up yang akan datang.</p>
            @endforelse
        </div>

        <div class="card-surface rounded-2xl p-5">
            <h2 class="mb-4 text-lg font-semibold text-slate-900">Follow-up Sudah Lewat</h2>
            @forelse ($overdue as $application)
                <div class="calendar-overdue mb-3 rounded-xl border border-red-200 bg-red-50 p-3">
                    <div class="flex items-center justify-between">
                        <p class="font-semibold text-slate-800">{{ $application->company_name }}</p>
                        <span class="status-badge status-{{ Str::lower($application->status) }}">{{ $application->status }}</span>
                    </div>
                    <p class="mt-1 text-sm text-slate-600">{{ $application->job_position }}</p>
                    <p class="mt-2 text-xs font-medium text-red-700">{{ \Carbon\Carbon::parse($application->follow_up_date)->translatedFormat('d M Y') }}</p>
                </div>
            @empty
                <p class="text-sm text-slate-500">Tidak ada follow-up yang terlambat.</p>
            @endforelse
        </div>
    </div>

    <div class="card-surface rounded-2xl p-5">
        <h2 class="mb-4 text-lg font-semibold text-slate-900">Semua Jadwal</h2>
        <div class="space-y-3">
            @forelse ($jobs as $application)
                <div class="flex items-center justify-between rounded-xl border border-slate-200 p-3">
                    <div>
                        <p class="font-semibold text-slate-800">{{ $application->company_name }}</p>
                        <p class="text-sm text-slate-600">{{ $application->job_position }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-slate-700">{{ \Carbon\Carbon::parse($application->follow_up_date)->translatedFormat('d M Y') }}</p>
                        <a href="{{ route('applications.show', $application) }}" class="text-xs font-medium text-indigo-600">Open</a>
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-500">Belum ada jadwal follow-up.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

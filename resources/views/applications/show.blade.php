@extends('layout')

@section('title', 'Detail Lamaran | JobTrack')
@section('page_title', 'Detail Lamaran')

@section('content')
<div class="space-y-6">
    <div class="card-surface rounded-2xl p-5">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm text-slate-500">{{ $application->company_name }}</p>
                <h2 class="text-2xl font-bold text-slate-900">{{ $application->job_position }}</h2>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('applications.edit', $application) }}" class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Edit Lamaran</a>
                <form action="{{ route('applications.destroy', $application) }}" method="POST" onsubmit="return confirm('Hapus lamaran ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded-xl border border-red-200 bg-red-50 px-4 py-2 text-sm font-semibold text-red-700">Hapus</button>
                </form>
            </div>
        </div>
        <div class="mt-4">
            <span class="status-badge status-{{ Str::lower($application->status) }}">{{ $application->status }}</span>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-3">
        <div class="card-surface rounded-2xl p-5 xl:col-span-2">
            <h3 class="mb-4 text-lg font-semibold text-slate-900">Informasi Lamaran</h3>
            <div class="grid gap-4 md:grid-cols-2">
                <div><p class="text-xs uppercase tracking-wide text-slate-400">Perusahaan</p><p class="mt-1 font-medium text-slate-800">{{ $application->company_name }}</p></div>
                <div><p class="text-xs uppercase tracking-wide text-slate-400">Posisi</p><p class="mt-1 font-medium text-slate-800">{{ $application->job_position }}</p></div>
                <div><p class="text-xs uppercase tracking-wide text-slate-400">Lokasi</p><p class="mt-1 font-medium text-slate-800">{{ $application->job_location ?: '-' }}</p></div>
                <div><p class="text-xs uppercase tracking-wide text-slate-400">Tipe Pekerjaan</p><p class="mt-1 font-medium text-slate-800">{{ $application->employment_type }}</p></div>
                <div><p class="text-xs uppercase tracking-wide text-slate-400">Sistem Kerja</p><p class="mt-1 font-medium text-slate-800">{{ $application->work_arrangement }}</p></div>
                <div><p class="text-xs uppercase tracking-wide text-slate-400">Tanggal Melamar</p><p class="mt-1 font-medium text-slate-800">{{ \Carbon\Carbon::parse($application->application_date)->translatedFormat('d M Y') }}</p></div>
                <div><p class="text-xs uppercase tracking-wide text-slate-400">Sumber Lowongan</p><p class="mt-1 font-medium text-slate-800">{{ $application->source }}</p></div>
                <div><p class="text-xs uppercase tracking-wide text-slate-400">Link Lowongan</p><p class="mt-1 font-medium text-slate-800">{{ $application->job_url ? '<a href="'.$application->job_url.'" class="text-indigo-600" target="_blank">Buka link</a>' : '-' }}</p></div>
                <div><p class="text-xs uppercase tracking-wide text-slate-400">Nama Recruiter</p><p class="mt-1 font-medium text-slate-800">{{ $application->recruiter_name ?: '-' }}</p></div>
                <div><p class="text-xs uppercase tracking-wide text-slate-400">Email Recruiter</p><p class="mt-1 font-medium text-slate-800">{{ $application->recruiter_email ?: '-' }}</p></div>
                <div><p class="text-xs uppercase tracking-wide text-slate-400">Gaji yang Diharapkan</p><p class="mt-1 font-medium text-slate-800">{{ $application->expected_salary ? 'Rp '.number_format($application->expected_salary, 0, ',', '.') : '-' }}</p></div>
                <div><p class="text-xs uppercase tracking-wide text-slate-400">Follow-up</p><p class="mt-1 font-medium text-slate-800">{{ $application->follow_up_date ? \Carbon\Carbon::parse($application->follow_up_date)->translatedFormat('d M Y') : '-' }}</p></div>
                <div class="md:col-span-2"><p class="text-xs uppercase tracking-wide text-slate-400">Catatan</p><p class="mt-1 whitespace-pre-wrap font-medium text-slate-800">{{ $application->notes ?: '-' }}</p></div>
            </div>
        </div>

        <div class="card-surface rounded-2xl p-5">
            <h3 class="mb-4 text-lg font-semibold text-slate-900">Ubah Status</h3>
            <form action="{{ route('applications.status', $application) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                <select name="status" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none">
                    @foreach(['Dikirim','Ditinjau','Diterima','Ditolak'] as $status)
                        <option value="{{ $status }}" {{ $application->status === $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
                <textarea name="notes" rows="4" placeholder="Catatan perubahan status" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none"></textarea>
                <button type="submit" class="w-full rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white">Ubah Status</button>
            </form>
        </div>
    </div>

    <div class="card-surface rounded-2xl p-5">
        <h3 class="mb-4 text-lg font-semibold text-slate-900">Riwayat Status</h3>
        <div class="space-y-4">
            @forelse ($application->statusHistories as $history)
                <div class="flex gap-3 rounded-xl border border-slate-200 p-3">
                    <div class="mt-1 h-3 w-3 rounded-full bg-indigo-500"></div>
                    <div>
                        <p class="text-sm font-semibold text-slate-800">{{ $history->previous_status ? 'Status berubah dari '.$history->previous_status.' menjadi '.$history->new_status : 'Lamaran dibuat dengan status '.$history->new_status }}</p>
                        <p class="mt-1 text-xs text-slate-500">{{ \Carbon\Carbon::parse($history->created_at)->translatedFormat('d M Y, H:i') }}</p>
                        @if ($history->notes)
                            <p class="mt-2 text-sm text-slate-600">{{ $history->notes }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-500">Belum ada riwayat status.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@extends('layout')

@section('title', 'Tambah Lamaran | JobTrack')
@section('page_title', 'Tambah Lamaran')

@section('content')
<div class="card-surface rounded-2xl p-6">
    <form action="{{ route('applications.store') }}" method="POST" class="grid gap-5 md:grid-cols-2">
        @csrf

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Nama Perusahaan <span class="text-red-500">*</span></label>
            <input type="text" name="company_name" value="{{ old('company_name') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Posisi / Jabatan <span class="text-red-500">*</span></label>
            <input type="text" name="job_position" value="{{ old('job_position') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Lokasi Pekerjaan</label>
            <input type="text" name="job_location" value="{{ old('job_location') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Tipe Pekerjaan</label>
            <select name="employment_type" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none">
                @foreach(['Full-time','Part-time','Internship','Contract','Freelance'] as $type)
                    <option value="{{ $type }}" {{ old('employment_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Sistem Kerja</label>
            <select name="work_arrangement" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none">
                @foreach(['On-site','Hybrid','Remote'] as $work)
                    <option value="{{ $work }}" {{ old('work_arrangement') === $work ? 'selected' : '' }}>{{ $work }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Tanggal Melamar <span class="text-red-500">*</span></label>
            <input type="date" name="application_date" value="{{ old('application_date', date('Y-m-d')) }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Sumber Lowongan</label>
            <select name="source" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none">
                @foreach(['LinkedIn','JobStreet','Glints','Website Perusahaan','Referral','Lainnya'] as $source)
                    <option value="{{ $source }}" {{ old('source') === $source ? 'selected' : '' }}>{{ $source }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Link Lowongan</label>
            <input type="url" name="job_url" value="{{ old('job_url') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Nama Recruiter</label>
            <input type="text" name="recruiter_name" value="{{ old('recruiter_name') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Email Recruiter</label>
            <input type="email" name="recruiter_email" value="{{ old('recruiter_email') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Status Lamaran</label>
            <select name="status" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none">
                @foreach(['Dikirim','Ditinjau','Diterima','Ditolak'] as $status)
                    <option value="{{ $status }}" {{ old('status', 'Dikirim') === $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Gaji yang Diharapkan</label>
            <input type="number" name="expected_salary" value="{{ old('expected_salary') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Tanggal Follow-up</label>
            <input type="date" name="follow_up_date" value="{{ old('follow_up_date') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none">
        </div>
        <div class="md:col-span-2">
            <label class="mb-1 block text-sm font-medium text-slate-700">Catatan</label>
            <textarea name="notes" rows="4" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none">{{ old('notes') }}</textarea>
        </div>

        <div class="md:col-span-2 flex justify-end gap-3 pt-2">
            <a href="{{ route('applications.index') }}" class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700">Batal</a>
            <button type="submit" class="rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white">Simpan Lamaran</button>
        </div>
    </form>
</div>
@endsection

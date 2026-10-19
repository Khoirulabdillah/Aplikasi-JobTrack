@extends('layout')

@section('title', 'Pengaturan Aplikasi | JobTrack')
@section('page_title', 'Pengaturan Aplikasi')

@section('content')
<div class="grid gap-6 lg:grid-cols-3">
    <div class="card-surface rounded-2xl p-5">
        <p class="text-sm text-slate-500">Total Lamaran</p>
        <p class="mt-3 text-3xl font-bold text-slate-900">{{ $data['total'] }}</p>
    </div>
    <div class="card-surface rounded-2xl p-5">
        <p class="text-sm text-slate-500">Follow-up Akan Datang</p>
        <p class="mt-3 text-3xl font-bold text-slate-900">{{ $data['upcoming'] }}</p>
    </div>
    <div class="card-surface rounded-2xl p-5">
        <p class="text-sm text-slate-500">Follow-up Lewat Waktu</p>
        <p class="mt-3 text-3xl font-bold text-slate-900">{{ $data['overdue'] }}</p>
    </div>

    <div class="card-surface rounded-2xl p-5 lg:col-span-3">
        <h2 class="text-lg font-semibold text-slate-900">Informasi Aplikasi</h2>
        <div class="mt-4 space-y-3 text-sm text-slate-600">
            <p>JobTrack dirancang untuk satu workspace pribadi, tanpa login atau multi-user.</p>
            <p>Semua data disimpan secara lokal di database dan dapat dibuka ulang setelah aplikasi dijalankan kembali.</p>
            <p>Untuk menjaga kerahasiaan data, prioritaskan penggunaan di lingkungan lokal atau jaringan yang dibatasi aksesnya.</p>
        </div>
    </div>
</div>
@endsection

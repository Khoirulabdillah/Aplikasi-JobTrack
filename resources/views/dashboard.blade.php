@extends('layout')

@section('title', 'Dashboard | JobTrack')
@section('page_title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
        <div class="card-surface rounded-2xl p-5">
            <p class="text-sm text-slate-500">Total Lamaran</p>
            <div class="mt-3 flex items-center justify-between">
                <span class="text-3xl font-bold text-slate-900">{{ $stats['total'] ?? 0 }}</span>
                <span class="rounded-full bg-indigo-100 px-2 py-1 text-xs font-semibold text-indigo-700">All</span>
            </div>
        </div>
        <div class="card-surface rounded-2xl p-5">
            <p class="text-sm text-slate-500">Lamaran Dikirim</p>
            <div class="mt-3 flex items-center justify-between">
                <span class="text-3xl font-bold text-slate-900">{{ $stats['Dikirim'] ?? 0 }}</span>
                <span class="rounded-full bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-700">Sent</span>
            </div>
        </div>
        <div class="card-surface rounded-2xl p-5">
            <p class="text-sm text-slate-500">Lamaran Ditinjau</p>
            <div class="mt-3 flex items-center justify-between">
                <span class="text-3xl font-bold text-slate-900">{{ $stats['Ditinjau'] ?? 0 }}</span>
                <span class="rounded-full bg-yellow-100 px-2 py-1 text-xs font-semibold text-yellow-700">Review</span>
            </div>
        </div>
        <div class="card-surface rounded-2xl p-5">
            <p class="text-sm text-slate-500">Lamaran Diterima</p>
            <div class="mt-3 flex items-center justify-between">
                <span class="text-3xl font-bold text-slate-900">{{ $stats['Diterima'] ?? 0 }}</span>
                <span class="rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-700">Offer</span>
            </div>
        </div>
        <div class="card-surface rounded-2xl p-5">
            <p class="text-sm text-slate-500">Lamaran Ditolak</p>
            <div class="mt-3 flex items-center justify-between">
                <span class="text-3xl font-bold text-slate-900">{{ $stats['Ditolak'] ?? 0 }}</span>
                <span class="rounded-full bg-red-100 px-2 py-1 text-xs font-semibold text-red-700">Rejected</span>
            </div>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-3">
        <div class="card-surface rounded-2xl p-5 xl:col-span-2">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-slate-900">Distribusi Status</h2>
            </div>
            <div class="h-72">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
        <div class="card-surface rounded-2xl p-5">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-slate-900">Lamaran per Bulan</h2>
            </div>
            <div class="h-72">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-2">
        <div class="card-surface rounded-2xl p-5">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-slate-900">Lima Lamaran Terbaru</h2>
                <a href="{{ route('applications.index') }}" class="text-sm font-medium text-indigo-600">Lihat semua</a>
            </div>

            @if ($recentApplications->isEmpty())
                <div class="rounded-xl border border-dashed border-slate-200 bg-slate-50 p-6 text-sm text-slate-500">
                    Belum ada data lamaran. Mulai dengan menambahkan lamaran baru.
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($recentApplications as $application)
                        <div class="flex items-center justify-between gap-3 rounded-xl border border-slate-200 p-3">
                            <div>
                                <p class="font-semibold text-slate-800">{{ $application->company_name }}</p>
                                <p class="text-sm text-slate-500">{{ $application->job_position }}</p>
                            </div>
                            <div class="text-right">
                                <span class="status-badge status-{{ Str::lower($application->status) }}">{{ $application->status }}</span>
                                <p class="mt-1 text-xs text-slate-400">{{ \Carbon\Carbon::parse($application->application_date)->translatedFormat('d M Y') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="card-surface rounded-2xl p-5">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-slate-900">Follow-up Terdekat</h2>
            </div>

            @if ($upcomingFollowUps->isEmpty())
                <div class="rounded-xl border border-dashed border-slate-200 bg-slate-50 p-6 text-sm text-slate-500">
                    Belum ada jadwal follow-up yang akan datang.
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($upcomingFollowUps as $application)
                        <div class="rounded-xl border border-slate-200 p-3">
                            <div class="flex items-center justify-between gap-3">
                                <p class="font-semibold text-slate-800">{{ $application->company_name }}</p>
                                <span class="status-badge status-{{ Str::lower($application->status) }}">{{ $application->status }}</span>
                            </div>
                            <p class="mt-1 text-sm text-slate-600">{{ $application->job_position }}</p>
                            <p class="mt-2 text-xs font-medium text-indigo-700">
                                {{ \Carbon\Carbon::parse($application->follow_up_date)->translatedFormat('d M Y') }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const statusCtx = document.getElementById('statusChart');
    const monthlyCtx = document.getElementById('monthlyChart');
    const isDarkMode = () => document.documentElement.classList.contains('dark');
    const chartTextColor = () => isDarkMode() ? '#f8fafc' : '#666666';

    const statusChart = new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: @json($statusChartLabels),
            datasets: [{
                data: @json($statusChartData),
                backgroundColor: ['#3b82f6', '#fbbf24', '#22c55e', '#ef4444'],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { color: chartTextColor() },
                },
            }
        }
    });

    const monthlyChart = new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: @json($monthlyLabels),
            datasets: [{
                label: 'Lamaran',
                data: @json($monthlyData),
                backgroundColor: '#4f46e5',
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: {
                    ticks: { color: chartTextColor() },
                    grid: {
                        color: () => isDarkMode()
                            ? 'rgba(255, 255, 255, 0.18)'
                            : '#e0e0e0',
                    },
                },
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0, color: chartTextColor() },
                    grid: {
                        color: () => isDarkMode()
                            ? 'rgba(255, 255, 255, 0.18)'
                            : '#e0e0e0',
                    },
                },
            }
        }
    });

    new MutationObserver(() => {
        const textColor = chartTextColor();
        statusChart.options.plugins.legend.labels.color = textColor;
        monthlyChart.options.scales.x.ticks.color = textColor;
        monthlyChart.options.scales.y.ticks.color = textColor;
        statusChart.update();
        monthlyChart.update();
    })
        .observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
</script>
@endsection

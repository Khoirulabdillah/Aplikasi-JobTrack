<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $statuses = ['Dikirim', 'Ditinjau', 'Diterima', 'Ditolak'];

        $statusCounts = JobApplication::query()
            ->select('status')
            ->selectRaw('COUNT(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        $stats = array_fill_keys($statuses, 0);
        foreach ($statusCounts as $status => $count) {
            if (array_key_exists($status, $stats)) {
                $stats[$status] = (int) $count;
            }
        }

        $stats['total'] = (int) $statusCounts->sum();

        $statusChartLabels = $statuses;
        $statusChartData = array_map(fn (string $status) => (int) ($stats[$status] ?? 0), $statuses);

        $monthly = [];
        $start = Carbon::now()->startOfMonth()->subMonths(5);

        for ($i = 0; $i < 6; $i++) {
            $month = $start->copy()->addMonths($i);
            $key = $month->format('Y-m');
            $label = $month->translatedFormat('M Y');
            $monthly[$key] = [
                'label' => $label,
                'value' => JobApplication::whereMonth('application_date', $month->month)
                    ->whereYear('application_date', $month->year)
                    ->count(),
            ];
        }

        $monthlyLabels = array_map(fn ($item) => $item['label'], array_values($monthly));
        $monthlyData = array_map(fn ($item) => (int) $item['value'], array_values($monthly));

        $recentApplications = JobApplication::latest('created_at')->limit(5)->get();
        $upcomingFollowUps = JobApplication::whereNotNull('follow_up_date')
            ->whereDate('follow_up_date', '>=', now()->toDateString())
            ->orderBy('follow_up_date', 'asc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'stats',
            'statusChartLabels',
            'statusChartData',
            'monthlyLabels',
            'monthlyData',
            'recentApplications',
            'upcomingFollowUps'
        ));
    }
}

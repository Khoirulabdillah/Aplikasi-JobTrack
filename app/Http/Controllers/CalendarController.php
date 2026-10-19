<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\View\View;

class CalendarController extends Controller
{
    public function index(): View
    {
        $jobs = JobApplication::whereNotNull('follow_up_date')
            ->orderBy('follow_up_date', 'asc')
            ->get();

        $upcoming = $jobs->filter(fn ($job) => $job->follow_up_date >= now()->toDateString());
        $overdue = $jobs->filter(fn ($job) => $job->follow_up_date < now()->toDateString());

        return view('calendar.index', compact('jobs', 'upcoming', 'overdue'));
    }
}

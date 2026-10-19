<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $data = [
            'total' => JobApplication::count(),
            'upcoming' => JobApplication::whereNotNull('follow_up_date')->whereDate('follow_up_date', '>=', now()->toDateString())->count(),
            'overdue' => JobApplication::whereNotNull('follow_up_date')->whereDate('follow_up_date', '<', now()->toDateString())->count(),
        ];

        return view('settings.index', compact('data'));
    }
}

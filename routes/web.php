<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('applications', JobApplicationController::class);
Route::patch('/applications/{application}/status', [JobApplicationController::class, 'updateStatus'])->name('applications.status');

Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');
Route::get('/settings', [SettingsController::class, 'index'])->name('settings');

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobApplicationRequest;
use App\Http\Requests\UpdateJobApplicationRequest;
use App\Models\ApplicationStatusHistory;
use App\Models\JobApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class JobApplicationController extends Controller
{
    public function index(Request $request): View
    {
        $query = JobApplication::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                    ->orWhere('job_position', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('employment_type')) {
            $query->where('employment_type', $request->employment_type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('application_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('application_date', '<=', $request->date_to);
        }

        $sort = $request->get('sort', 'newest');

        match ($sort) {
            'oldest' => $query->orderBy('application_date', 'asc'),
            'company_asc' => $query->orderBy('company_name', 'asc'),
            'company_desc' => $query->orderBy('company_name', 'desc'),
            default => $query->orderBy('application_date', 'desc'),
        };

        $applications = $query->paginate(10)->appends($request->query());

        return view('applications.index', compact('applications'));
    }

    public function create(): View
    {
        return view('applications.create');
    }

    public function store(StoreJobApplicationRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $application = DB::transaction(function () use ($validated) {
            $application = JobApplication::create($validated);

            ApplicationStatusHistory::create([
                'job_application_id' => $application->id,
                'previous_status' => null,
                'new_status' => $application->status,
                'notes' => $application->notes,
                'created_at' => now(),
            ]);

            return $application;
        });

        return redirect()->route('applications.show', $application)
            ->with('success', 'Lamaran berhasil disimpan.');
    }

    public function show(JobApplication $application): View
    {
        $application->load(['statusHistories' => function ($query) {
            $query->orderBy('created_at', 'asc');
        }]);

        return view('applications.show', compact('application'));
    }

    public function edit(JobApplication $application): View
    {
        return view('applications.edit', compact('application'));
    }

    public function update(UpdateJobApplicationRequest $request, JobApplication $application): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($application, $validated) {
            $previousStatus = $application->status;
            $application->fill($validated);
            $application->save();

            if (isset($validated['status']) && $validated['status'] !== $previousStatus) {
                $this->recordStatusHistory($application, $previousStatus, $validated['status'], $validated['notes'] ?? null);
            }
        });

        return redirect()->route('applications.show', $application)
            ->with('success', 'Lamaran berhasil diperbarui.');
    }

    public function destroy(JobApplication $application): RedirectResponse
    {
        DB::transaction(function () use ($application) {
            $application->delete();
        });

        return redirect()->route('applications.index')
            ->with('success', 'Lamaran berhasil dihapus.');
    }

    public function updateStatus(Request $request, JobApplication $application): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:Dikirim,Ditinjau,Diterima,Ditolak'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($request, $application) {
            $previousStatus = $application->status;
            $newStatus = $request->status;

            if ($previousStatus !== $newStatus) {
                $application->status = $newStatus;
                $application->save();
                $this->recordStatusHistory($application, $previousStatus, $newStatus, $request->notes);
            }
        });

        return redirect()->route('applications.show', $application)
            ->with('success', 'Status lamaran berhasil diperbarui.');
    }

    private function recordStatusHistory(JobApplication $application, ?string $previousStatus, string $newStatus, ?string $notes = null): void
    {
        ApplicationStatusHistory::create([
            'job_application_id' => $application->id,
            'previous_status' => $previousStatus,
            'new_status' => $newStatus,
            'notes' => $notes,
            'created_at' => now(),
        ]);
    }
}

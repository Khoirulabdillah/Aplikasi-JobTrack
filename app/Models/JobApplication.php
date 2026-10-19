<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobApplication extends Model
{
    protected $fillable = [
        'company_name',
        'job_position',
        'job_location',
        'employment_type',
        'work_arrangement',
        'application_date',
        'source',
        'job_url',
        'recruiter_name',
        'recruiter_email',
        'status',
        'expected_salary',
        'follow_up_date',
        'notes',
    ];

    protected $casts = [
        'application_date' => 'date:Y-m-d',
        'follow_up_date' => 'date:Y-m-d',
        'expected_salary' => 'decimal:2',
    ];

    public function statusHistories(): HasMany
    {
        return $this->hasMany(ApplicationStatusHistory::class)->orderBy('created_at', 'desc');
    }
}

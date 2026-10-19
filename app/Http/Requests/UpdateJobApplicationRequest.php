<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_name' => ['sometimes', 'required', 'string', 'max:255'],
            'job_position' => ['sometimes', 'required', 'string', 'max:255'],
            'job_location' => ['nullable', 'string', 'max:255'],
            'employment_type' => ['sometimes', 'required', 'in:Full-time,Part-time,Internship,Contract,Freelance'],
            'work_arrangement' => ['sometimes', 'required', 'in:On-site,Hybrid,Remote'],
            'application_date' => ['sometimes', 'required', 'date'],
            'source' => ['sometimes', 'required', 'in:LinkedIn,JobStreet,Glints,Website Perusahaan,Referral,Lainnya'],
            'job_url' => ['nullable', 'url', 'max:255'],
            'recruiter_name' => ['nullable', 'string', 'max:255'],
            'recruiter_email' => ['nullable', 'email', 'max:255'],
            'status' => ['sometimes', 'required', 'in:Dikirim,Ditinjau,Diterima,Ditolak'],
            'expected_salary' => ['nullable', 'numeric', 'min:0'],
            'follow_up_date' => ['nullable', 'date', 'after_or_equal:application_date'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }
}

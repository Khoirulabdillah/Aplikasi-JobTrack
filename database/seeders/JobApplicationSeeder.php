<?php

namespace Database\Seeders;

use App\Models\ApplicationStatusHistory;
use App\Models\JobApplication;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class JobApplicationSeeder extends Seeder
{
    public function run(): void
    {
        JobApplication::query()->delete();
        ApplicationStatusHistory::query()->delete();

        $records = [
            [
                'company_name' => 'PT Maju Bersama',
                'job_position' => 'Senior Backend Developer',
                'job_location' => 'Jakarta Selatan',
                'employment_type' => 'Full-time',
                'work_arrangement' => 'Hybrid',
                'application_date' => '2026-09-10',
                'source' => 'LinkedIn',
                'job_url' => 'https://example.com/jobs/backend',
                'recruiter_name' => 'Maya Sari',
                'recruiter_email' => 'maya@example.com',
                'status' => 'Diterima',
                'expected_salary' => 22000000,
                'follow_up_date' => '2026-10-25',
                'notes' => 'Lamaran diterima dan menunggu tahap onboarding.',
                'history' => [
                    ['previous_status' => null, 'new_status' => 'Dikirim', 'notes' => 'Lamaran dikirim melalui LinkedIn.'],
                    ['previous_status' => 'Dikirim', 'new_status' => 'Ditinjau', 'notes' => 'CV masuk tahap interview screening.'],
                    ['previous_status' => 'Ditinjau', 'new_status' => 'Diterima', 'notes' => 'Diterima untuk posisi Senior Backend Developer.'],
                ],
            ],
            [
                'company_name' => 'PT Nusantara Digital',
                'job_position' => 'Product Designer',
                'job_location' => 'Bandung',
                'employment_type' => 'Full-time',
                'work_arrangement' => 'Remote',
                'application_date' => '2026-10-04',
                'source' => 'Glints',
                'job_url' => 'https://example.com/jobs/product-designer',
                'recruiter_name' => 'Rizky',
                'recruiter_email' => 'rizky@example.com',
                'status' => 'Ditinjau',
                'expected_salary' => 18000000,
                'follow_up_date' => '2026-10-18',
                'notes' => 'Masih menunggu hasil portfolio review.',
                'history' => [
                    ['previous_status' => null, 'new_status' => 'Dikirim', 'notes' => 'Lamaran dikirim via Glints.'],
                    ['previous_status' => 'Dikirim', 'new_status' => 'Ditinjau', 'notes' => 'Portfolio dinilai sesuai kebutuhan.'],
                ],
            ],
            [
                'company_name' => 'CV Karya Inovasi',
                'job_position' => 'QA Engineer',
                'job_location' => 'Yogyakarta',
                'employment_type' => 'Contract',
                'work_arrangement' => 'On-site',
                'application_date' => '2026-10-07',
                'source' => 'JobStreet',
                'job_url' => 'https://example.com/jobs/qa',
                'recruiter_name' => 'Dewi',
                'recruiter_email' => 'dewi@example.com',
                'status' => 'Dikirim',
                'expected_salary' => 15000000,
                'follow_up_date' => '2026-10-21',
                'notes' => 'Menunggu balasan dari recruiter terkait jadwal test.',
                'history' => [
                    ['previous_status' => null, 'new_status' => 'Dikirim', 'notes' => 'Lamaran dikirim.'],
                ],
            ],
            [
                'company_name' => 'Startup Labs',
                'job_position' => 'Frontend Engineer',
                'job_location' => 'Jakarta Pusat',
                'employment_type' => 'Full-time',
                'work_arrangement' => 'Remote',
                'application_date' => '2026-08-12',
                'source' => 'Referral',
                'job_url' => 'https://example.com/jobs/frontend',
                'recruiter_name' => 'Hana',
                'recruiter_email' => 'hana@example.com',
                'status' => 'Ditolak',
                'expected_salary' => 17000000,
                'follow_up_date' => '2026-10-15',
                'notes' => 'Tidak lolos tahap final interview.',
                'history' => [
                    ['previous_status' => null, 'new_status' => 'Dikirim', 'notes' => 'Lamaran dikirim melalui referral.'],
                    ['previous_status' => 'Dikirim', 'new_status' => 'Ditinjau', 'notes' => 'Screening selesai.'],
                    ['previous_status' => 'Ditinjau', 'new_status' => 'Ditolak', 'notes' => 'Panduan final interview tidak sesuai kriteria.'],
                ],
            ],
            [
                'company_name' => 'PT Awan Teknologi',
                'job_position' => 'Mobile Developer',
                'job_location' => 'Surabaya',
                'employment_type' => 'Part-time',
                'work_arrangement' => 'Hybrid',
                'application_date' => '2026-10-12',
                'source' => 'Website Perusahaan',
                'job_url' => 'https://example.com/jobs/mobile',
                'recruiter_name' => 'Bobby',
                'recruiter_email' => 'bobby@example.com',
                'status' => 'Dikirim',
                'expected_salary' => 12000000,
                'follow_up_date' => '2026-10-20',
                'notes' => 'Membutuhkan portofolio aplikasi mobile.',
                'history' => [
                    ['previous_status' => null, 'new_status' => 'Dikirim', 'notes' => 'Lamaran dikirim lewat website perusahaan.'],
                ],
            ],
            [
                'company_name' => 'PT Solusi Cerdas',
                'job_position' => 'Data Analyst',
                'job_location' => 'Remote',
                'employment_type' => 'Internship',
                'work_arrangement' => 'Remote',
                'application_date' => '2026-09-18',
                'source' => 'LinkedIn',
                'job_url' => 'https://example.com/jobs/data-analyst',
                'recruiter_name' => 'Fajar',
                'recruiter_email' => 'fajar@example.com',
                'status' => 'Ditinjau',
                'expected_salary' => 9000000,
                'follow_up_date' => '2026-10-24',
                'notes' => 'Menunggu hasil assessment data analytics.',
                'history' => [
                    ['previous_status' => null, 'new_status' => 'Dikirim', 'notes' => 'Lamaran sukses dikirim.'],
                    ['previous_status' => 'Dikirim', 'new_status' => 'Ditinjau', 'notes' => 'Assesment sedang diproses.'],
                ],
            ],
        ];

        foreach ($records as $record) {
            $jobApplication = JobApplication::create([
                'company_name' => $record['company_name'],
                'job_position' => $record['job_position'],
                'job_location' => $record['job_location'],
                'employment_type' => $record['employment_type'],
                'work_arrangement' => $record['work_arrangement'],
                'application_date' => $record['application_date'],
                'source' => $record['source'],
                'job_url' => $record['job_url'],
                'recruiter_name' => $record['recruiter_name'],
                'recruiter_email' => $record['recruiter_email'],
                'status' => $record['status'],
                'expected_salary' => $record['expected_salary'],
                'follow_up_date' => $record['follow_up_date'],
                'notes' => $record['notes'],
            ]);

            foreach ($record['history'] as $item) {
                ApplicationStatusHistory::create([
                    'job_application_id' => $jobApplication->id,
                    'previous_status' => $item['previous_status'],
                    'new_status' => $item['new_status'],
                    'notes' => $item['notes'],
                    'created_at' => Carbon::parse($jobApplication->application_date)->addDays(rand(1, 12)),
                ]);
            }
        }
    }
}

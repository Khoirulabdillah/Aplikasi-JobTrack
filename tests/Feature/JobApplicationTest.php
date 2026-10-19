<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_job_application(): void
    {
        $response = $this->post('/applications', [
            'company_name' => 'PT Maju Bersama',
            'job_position' => 'Senior Backend Developer',
            'job_location' => 'Jakarta',
            'employment_type' => 'Full-time',
            'work_arrangement' => 'Hybrid',
            'application_date' => '2026-10-10',
            'source' => 'LinkedIn',
            'job_url' => 'https://example.com/jobs/backend',
            'recruiter_name' => 'Andi',
            'recruiter_email' => 'andi@example.com',
            'status' => 'Dikirim',
            'expected_salary' => '18000000',
            'follow_up_date' => '2026-10-17',
            'notes' => 'Melamar posisi backend.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('job_applications', [
            'company_name' => 'PT Maju Bersama',
            'status' => 'Dikirim',
        ]);
    }

    public function test_can_show_job_application_detail_with_history(): void
    {
        $this->post('/applications', [
            'company_name' => 'PT Digital Nusantara',
            'job_position' => 'Product Designer',
            'employment_type' => 'Full-time',
            'work_arrangement' => 'Remote',
            'application_date' => '2026-10-11',
            'source' => 'Glints',
            'status' => 'Dikirim',
        ]);

        $response = $this->get('/applications/1');

        $response->assertOk();
        $response->assertSee('PT Digital Nusantara');
    }

    public function test_can_update_status_and_store_history(): void
    {
        $this->post('/applications', [
            'company_name' => 'PT Inovasi Teknologi',
            'job_position' => 'Frontend Engineer',
            'employment_type' => 'Full-time',
            'work_arrangement' => 'Remote',
            'application_date' => '2026-10-12',
            'source' => 'JobStreet',
            'status' => 'Dikirim',
        ]);

        $response = $this->patch('/applications/1/status', [
            'status' => 'Ditinjau',
            'notes' => 'CV dipanggil untuk interview.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('job_applications', [
            'id' => 1,
            'status' => 'Ditinjau',
        ]);
        $this->assertDatabaseHas('application_status_histories', [
            'job_application_id' => 1,
            'previous_status' => 'Dikirim',
            'new_status' => 'Ditinjau',
        ]);
    }

    public function test_can_delete_job_application_and_its_histories(): void
    {
        $this->post('/applications', [
            'company_name' => 'PT Data Kreatif',
            'job_position' => 'Data Analyst',
            'employment_type' => 'Contract',
            'work_arrangement' => 'Hybrid',
            'application_date' => '2026-10-13',
            'source' => 'Referral',
            'status' => 'Dikirim',
        ]);

        $this->patch('/applications/1/status', ['status' => 'Ditinjau']);

        $response = $this->delete('/applications/1');

        $response->assertRedirect();
        $this->assertDatabaseMissing('job_applications', ['id' => 1]);
        $this->assertDatabaseMissing('application_status_histories', ['job_application_id' => 1]);
    }

    public function test_invalid_submission_is_rejected(): void
    {
        $response = $this->post('/applications', [
            'company_name' => '',
            'job_position' => '',
            'employment_type' => 'Unknown',
            'application_date' => '',
            'source' => 'Unknown',
        ]);

        $response->assertSessionHasErrors(['company_name', 'job_position', 'employment_type', 'application_date', 'source']);
    }
}

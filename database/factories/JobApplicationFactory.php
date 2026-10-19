<?php

namespace Database\Factories;

use App\Models\JobApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobApplicationFactory extends Factory
{
    protected $model = JobApplication::class;

    public function definition(): array
    {
        return [
            'company_name' => $this->faker->company(),
            'job_position' => $this->faker->jobTitle(),
            'job_location' => $this->faker->city(),
            'employment_type' => $this->faker->randomElement(['Full-time', 'Part-time', 'Internship', 'Contract', 'Freelance']),
            'work_arrangement' => $this->faker->randomElement(['On-site', 'Hybrid', 'Remote']),
            'application_date' => $this->faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
            'source' => $this->faker->randomElement(['LinkedIn', 'JobStreet', 'Glints', 'Website Perusahaan', 'Referral', 'Lainnya']),
            'job_url' => $this->faker->optional()->url(),
            'recruiter_name' => $this->faker->optional()->name(),
            'recruiter_email' => $this->faker->optional()->safeEmail(),
            'status' => $this->faker->randomElement(['Dikirim', 'Ditinjau', 'Diterima', 'Ditolak']),
            'expected_salary' => $this->faker->optional()->numberBetween(8000000, 30000000),
            'follow_up_date' => $this->faker->optional()->dateTimeBetween('now', '+2 months')->format('Y-m-d'),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\ApplicationStatusHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationStatusHistoryFactory extends Factory
{
    protected $model = ApplicationStatusHistory::class;

    public function definition(): array
    {
        return [
            'previous_status' => $this->faker->randomElement(['Dikirim', 'Ditinjau', 'Diterima', 'Ditolak', null]),
            'new_status' => $this->faker->randomElement(['Dikirim', 'Ditinjau', 'Diterima', 'Ditolak']),
            'notes' => $this->faker->optional()->sentence(),
            'created_at' => now(),
        ];
    }
}

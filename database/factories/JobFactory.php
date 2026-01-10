<?php

namespace Database\Factories;

use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    protected $model = Job::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->paragraph(),
            'company_name' => $this->faker->company(), // ✅ add this
            'company_logo' => null, // optional
            'location' => $this->faker->city(),
            'salary' => $this->faker->numberBetween(20000, 100000),
            'job_type' => $this->faker->randomElement(['full-time', 'part-time', 'contract', 'remote']),
            'experience_level' => $this->faker->randomElement(['junior', 'mid', 'senior']),
            'skills_required' => $this->faker->randomElements(['PHP', 'Laravel', 'JavaScript', 'Vue', 'React'], 3),
            'benefits' => $this->faker->randomElements(['Health Insurance', 'Paid Leave', 'Remote Work', 'Bonus'], 2),
            'application_deadline' => $this->faker->dateTimeBetween('now', '+1 month'),
            'is_active' => true,
            'status' => 'approved',
            'views' => 0,
        ];
    }
}

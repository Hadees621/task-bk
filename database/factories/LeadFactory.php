<?php

namespace Database\Factories;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadFactory extends Factory
{
    protected $model = Lead::class;

    public function definition(): array
    {
        return [
            'full_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone_number' => $this->faker->phoneNumber(),
            'source' => $this->faker->randomElement(['website', 'linkedin', 'referral', 'cold call']),
            'status' => $this->faker->randomElement(['new', 'contacted', 'qualified', 'converted', 'lost']),
            'assigned_to' => null, // or random user ID if you have a users table
            'company_name' => $this->faker->company(),
            'lead_score' => $this->faker->numberBetween(1, 100),
            'notes' => $this->faker->sentence(12),
        ];
    }
}

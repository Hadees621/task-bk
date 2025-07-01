<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomersFactory extends Factory
{
    public function definition(): array
    {
        return [
            'first_name'           => $this->faker->firstName,
            'last_name'            => $this->faker->lastName,
            'email'                => $this->faker->unique()->safeEmail,
            'personal_phone'       => $this->faker->phoneNumber,
            'description'          => $this->faker->sentence,
            'address'              => $this->faker->address,
            'business_phone'       => $this->faker->phoneNumber,
            'home_phone'           => $this->faker->phoneNumber,
            'nationality'          => $this->faker->country,
            'country_of_residence' => $this->faker->country,
            'dob'                  => $this->faker->date('Y-m-d', '2005-01-01'),
            'gender'               => $this->faker->randomElement(['male', 'female', 'other']),
        ];
    }
}

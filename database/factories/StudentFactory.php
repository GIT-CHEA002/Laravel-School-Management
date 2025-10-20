<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create([
            'role' => 'student',
            'password' => bcrypt('password'), // Default password for seeded students
        ]);

        return [
            'user_id' => $user->id,
            'student_code' => strtoupper('STU-'.$this->faker->unique()->numerify('###')),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'dob' => $this->faker->dateTimeBetween('-18 years', '-10 years'),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'parent_name' => $this->faker->name(),
            'parent_phone' => $this->faker->phoneNumber(),
        ];
    }
}

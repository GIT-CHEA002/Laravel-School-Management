<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClassFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'class_name' => 'Grade '.$this->faker->numberBetween(1, 12).$this->faker->randomElement(['A', 'B', 'C']),
            'academic_year' => $this->faker->randomElement(['2024-2025', '2025-2026']),
            'teacher_id' => Teacher::inRandomOrder()->first()?->id ?? Teacher::factory(),
        ];
    }
}

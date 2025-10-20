<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SchoolClass>
 */
class SchoolClassFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'class_name' => $this->faker->randomElement(['Grade 10A', 'Grade 10B', 'Grade 11A', 'Grade 12B']),
            'teacher_id' => \App\Models\Teacher::inRandomOrder()->first()?->id ?? \App\Models\Teacher::factory(),
            'room_number' => $this->faker->numberBetween(1, 20),
        ];
    }
}

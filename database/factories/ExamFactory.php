<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'exam_name' => $this->faker->randomElement(['Midterm', 'Final', 'Quiz']),
            'subject_id' => Subject::inRandomOrder()->first()?->id ?? Subject::factory(),
            'class_id' => \App\Models\SchoolClass::inRandomOrder()->first()?->id ?? \App\Models\SchoolClass::factory(),
            'exam_date' => $this->faker->dateTimeBetween('-2 months', '+2 months'),
            'max_score' => 100,
        ];
    }
}

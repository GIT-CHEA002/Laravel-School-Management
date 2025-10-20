<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Exam;
use App\Models\Fee;
use App\Models\Grade;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@school.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        // Teachers
        $teachers = Teacher::factory(10)->create();

        // Subjects
        $subjects = Subject::factory(8)->create();

        // Classes
        $classes = SchoolClass::factory(6)->create();

        // Students
        $students = Student::factory(50)->create();

        // Enroll students into random classes
        foreach ($students as $student) {
            \App\Models\Enrollment::create([
                'student_id' => $student->id,
                'class_id' => $classes->random()->id,
                'enrollment_date' => now()->subDays(rand(1, 100)),
            ]);
        }

        // Exams
        $exams = Exam::factory(10)->create();

        // Grades for students
        foreach ($students as $student) {
            foreach ($exams->random(3) as $exam) {
                Grade::create([
                    'student_id' => $student->id,
                    'exam_id' => $exam->id,
                    'score' => rand(40, 100),
                ]);
            }
        }

        // Attendance
        foreach ($students as $student) {
            for ($i = 0; $i < 10; $i++) {
                Attendance::create([
                    'student_id' => $student->id,
                    'school_class_id' => $classes->random()->id,
                    'date' => now()->subDays($i),
                    'status' => fake()->randomElement(['present', 'absent', 'late']),
                ]);
            }
        }

        // Fees
        foreach ($students as $student) {
            $amount_due = rand(100, 300);
            $status = fake()->randomElement(['paid', 'unpaid', 'partial']);
            $amount_paid = 0;

            if ($status === 'paid') {
                $amount_paid = $amount_due;
            } elseif ($status === 'partial') {
                $amount_paid = rand(1, $amount_due - 1);
            }

            Fee::create([
                'student_id' => $student->id,
                'amount_due' => $amount_due,
                'amount_paid' => $amount_paid,
                'status' => $status,
                'due_date' => now()->addDays(rand(10, 60)),
            ]);
        }

    }
}

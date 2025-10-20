<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'khang',
            'email' => 'khang@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);
        \App\Models\Attendance::create([
            'student_id' => 1,
            // 'class_id' => 4, // Remove this line if the column doesn't exist
            'date' => now(),
            'status' => 'present',
        ]);
    }
}

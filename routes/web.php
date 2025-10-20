<?php

use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EnrollmentController as AdminEnrollmentController;
use App\Http\Controllers\Admin\ExamController as AdminExamController;
use App\Http\Controllers\Admin\FeeController as AdminFeeController;
use App\Http\Controllers\Admin\GradeController as AdminGradeController;
use App\Http\Controllers\Admin\NoticeController as AdminNoticeController;
use App\Http\Controllers\Admin\SchoolClassController as AdminSchoolClassController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\SubjectController as AdminSubjectController;
use App\Http\Controllers\Admin\TeacherController as AdminTeacherController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', [AdminDashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/classes', [SchoolClassController::class, 'index'])->name('classes.index');
});

// Admin Panel
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resources([
        'users' => AdminUserController::class,
        'students' => AdminStudentController::class,
        'teachers' => AdminTeacherController::class,
        'classes' => AdminSchoolClassController::class,
        'subjects' => AdminSubjectController::class,
        'enrollments' => AdminEnrollmentController::class,
        'attendance' => AdminAttendanceController::class,
        'exams' => AdminExamController::class,
        'grades' => AdminGradeController::class,
        'fees' => AdminFeeController::class,
        'notices' => AdminNoticeController::class,
    ]);
    
    // Custom routes for class subject assignment
    Route::get('classes/{schoolClass}/assign-subjects', [AdminSchoolClassController::class, 'assignSubjects'])->name('classes.assign-subjects');
    Route::post('classes/{schoolClass}/assign-subjects', [AdminSchoolClassController::class, 'storeSubjects'])->name('classes.store-subjects');
    
    // Custom routes for exam results
    Route::get('exams/{exam}/results', [AdminExamController::class, 'showResults'])->name('exams.results');
    Route::post('exams/{exam}/results', [AdminExamController::class, 'storeResults'])->name('exams.store-results');
});

// Teacher Panel
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/', [TeacherDashboardController::class, 'index'])->name('dashboard');
});

// Student Panel
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/', [StudentDashboardController::class, 'index'])->name('dashboard');
});

require __DIR__.'/auth.php';


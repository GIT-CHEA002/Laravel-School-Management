<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\Attendance;
use App\Models\Enrollment;
use App\Models\Exam;
use App\Models\Notice;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalClasses = SchoolClass::count();

        // Get student statistics by gender
        $femaleStudents = Student::where('gender', 'female')->count();
        $maleStudents = Student::where('gender', 'male')->count();

        // Get all classes for dropdown
        $classes = SchoolClass::with('students')->get();

        // Get selected class or default to first class
        $selectedClassId = $request->get('class_id', $classes->first()?->id);
        $selectedClass = $classes->firstWhere('id', $selectedClassId);

        // Get students in selected class
        $studentsInClass = 0;
        $femaleInClass = 0;
        $maleInClass = 0;

        if ($selectedClass) {
            // Get students enrolled in this class through enrollments
            $studentIds = Enrollment::where('class_id', $selectedClass->id)->pluck('student_id');
            $studentsInClass = $studentIds->count();
            $femaleInClass = Student::whereIn('id', $studentIds)->where('gender', 'female')->count();
            $maleInClass = Student::whereIn('id', $studentIds)->where('gender', 'male')->count();
        }

        // Get attendance data based on selected period
        $period = $request->get('period', 'weekly'); // daily, weekly, monthly

        switch ($period) {
            case 'daily':
                $startDate = Carbon::today();
                $endDate = Carbon::today();
                break;
            case 'weekly':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;
            case 'monthly':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            default:
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
        }

        $attendances = Attendance::whereBetween('date', [$startDate, $endDate])->get();
        $attendanceCounts = $attendances->groupBy('status')->map->count();

        $presentCount = $attendanceCounts->get('present', 0);
        $absentCount = $attendanceCounts->get('absent', 0);
        $totalAttendance = $presentCount + $absentCount;

        $presentPercentage = $totalAttendance > 0 ? round(($presentCount / $totalAttendance) * 100) : 0;
        $absentPercentage = $totalAttendance > 0 ? round(($absentCount / $totalAttendance) * 100) : 0;

        // Get attendance chart data (7 days of data)
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dayAttendances = Attendance::whereDate('date', $date)->get();
            $dayPresent = $dayAttendances->where('status', 'present')->count();
            $dayAbsent = $dayAttendances->where('status', 'absent')->count();

            $chartData[] = [
                'date' => $date->format('M d'),
                'present' => $dayPresent,
                'absent' => $dayAbsent,
                'present_percentage' => ($dayPresent + $dayAbsent) > 0 ? round(($dayPresent / ($dayPresent + $dayAbsent)) * 100) : 0,
                'absent_percentage' => ($dayPresent + $dayAbsent) > 0 ? round(($dayAbsent / ($dayPresent + $dayAbsent)) * 100) : 0,
            ];
        }

        // Get exams today
        try {
            $examsToday = Exam::whereDate('exam_date', Carbon::today())->count();
        } catch (\Exception $e) {
            $examsToday = 0;
        }
        
        // Get active notices count
        try {
            $noticesCount = Notice::active()->count();
            // Get recent notices for dashboard
            $recentNotices = Notice::active()->with('creator')->latest()->take(5)->get();
        } catch (\Exception $e) {
            $noticesCount = 0;
            $recentNotices = collect();
        }
        
        // Get recent activities (new students in last 7 days)
        $recentStudents = Student::where('created_at', '>=', Carbon::now()->subDays(7))->count();
        
        // Get enrollment per class data for charts
        $enrollmentData = [];
        foreach ($classes as $class) {
            $studentCount = Enrollment::where('class_id', $class->id)->count();
            $enrollmentData[] = [
                'class_name' => $class->class_name,
                'student_count' => $studentCount
            ];
        }

        return view('dashboard', compact(
            'totalStudents',
            'totalTeachers',
            'totalClasses',
            'femaleStudents',
            'maleStudents',
            'classes',
            'selectedClass',
            'selectedClassId',
            'studentsInClass',
            'femaleInClass',
            'maleInClass',
            'presentCount',
            'absentCount',
            'presentPercentage',
            'absentPercentage',
            'period',
            'chartData',
            'examsToday',
            'noticesCount',
            'recentNotices',
            'recentStudents',
            'enrollmentData'
        ));
    }
}


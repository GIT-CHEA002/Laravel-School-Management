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
use App\Models\Grade;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Basic counts
            $totalStudents = Student::count();
            $totalTeachers = Teacher::count();
            $totalClasses = SchoolClass::count();

            // Get student statistics by gender
            $femaleStudents = Student::where('gender', 'female')->count();
            $maleStudents = Student::where('gender', 'male')->count();

            // Get all classes for dropdown with proper relationships
            $classes = SchoolClass::with(['teacher', 'subjects'])->get();

            // Get selected class or default to first class
            $selectedClassId = $request->get('class_id');
            $selectedClass = null;
            if ($selectedClassId) {
                $selectedClass = SchoolClass::find($selectedClassId);
            } else {
                $selectedClass = $classes->first();
                $selectedClassId = $selectedClass?->id;
            }

            // Get students in selected class using proper enrollment relationship
            $studentsInClass = 0;
            $femaleInClass = 0;
            $maleInClass = 0;

            if ($selectedClass) {
                // Get student IDs enrolled in this class through enrollments table
                $studentIds = Enrollment::where('class_id', $selectedClass->id)->pluck('student_id');
                $studentsInClass = $studentIds->count();
                
                if ($studentsInClass > 0) {
                    $femaleInClass = Student::whereIn('id', $studentIds)->where('gender', 'female')->count();
                    $maleInClass = Student::whereIn('id', $studentIds)->where('gender', 'male')->count();
                }
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

            // Filter attendance by selected class if specified
            $attendanceQuery = Attendance::whereBetween('date', [$startDate, $endDate]);
            if ($selectedClassId) {
                $attendanceQuery->where('school_class_id', $selectedClassId);
            }
            $attendances = $attendanceQuery->get();
            
            $attendanceCounts = $attendances->groupBy('status')->map->count();
            $presentCount = $attendanceCounts->get('present', 0);
            $absentCount = $attendanceCounts->get('absent', 0);
            $totalAttendance = $presentCount + $absentCount;

            $presentPercentage = $totalAttendance > 0 ? round(($presentCount / $totalAttendance) * 100) : 0;
            $absentPercentage = $totalAttendance > 0 ? round(($absentCount / $totalAttendance) * 100) : 0;

            // Get attendance chart data based on selected period
            $chartData = [];
            
            switch ($period) {
                case 'daily':
                    // Show data for the last 7 days
                    for ($i = 6; $i >= 0; $i--) {
                        $date = Carbon::now()->subDays($i);
                        $dayAttendanceQuery = Attendance::whereDate('date', $date);
                        if ($selectedClassId) {
                            $dayAttendanceQuery->where('school_class_id', $selectedClassId);
                        }
                        $dayAttendances = $dayAttendanceQuery->get();
                        
                        $dayPresent = $dayAttendances->where('status', 'present')->count();
                        $dayAbsent = $dayAttendances->where('status', 'absent')->count();
                        $dayTotal = $dayPresent + $dayAbsent;

                        $chartData[] = [
                            'date' => $date->format('M d'),
                            'present' => $dayPresent,
                            'absent' => $dayAbsent,
                            'present_percentage' => $dayTotal > 0 ? round(($dayPresent / $dayTotal) * 100) : 0,
                            'absent_percentage' => $dayTotal > 0 ? round(($dayAbsent / $dayTotal) * 100) : 0,
                        ];
                    }
                    break;
                    
                case 'weekly':
                    // Show data for the last 7 weeks
                    for ($i = 6; $i >= 0; $i--) {
                        $weekStart = Carbon::now()->subWeeks($i)->startOfWeek();
                        $weekEnd = Carbon::now()->subWeeks($i)->endOfWeek();
                        
                        $weekAttendanceQuery = Attendance::whereBetween('date', [$weekStart, $weekEnd]);
                        if ($selectedClassId) {
                            $weekAttendanceQuery->where('school_class_id', $selectedClassId);
                        }
                        $weekAttendances = $weekAttendanceQuery->get();
                        
                        $weekPresent = $weekAttendances->where('status', 'present')->count();
                        $weekAbsent = $weekAttendances->where('status', 'absent')->count();
                        $weekTotal = $weekPresent + $weekAbsent;

                        $chartData[] = [
                            'date' => $weekStart->format('M d'),
                            'present' => $weekPresent,
                            'absent' => $weekAbsent,
                            'present_percentage' => $weekTotal > 0 ? round(($weekPresent / $weekTotal) * 100) : 0,
                            'absent_percentage' => $weekTotal > 0 ? round(($weekAbsent / $weekTotal) * 100) : 0,
                        ];
                    }
                    break;
                    
                case 'monthly':
                    // Show data for the last 7 months
                    for ($i = 6; $i >= 0; $i--) {
                        $monthStart = Carbon::now()->subMonths($i)->startOfMonth();
                        $monthEnd = Carbon::now()->subMonths($i)->endOfMonth();
                        
                        $monthAttendanceQuery = Attendance::whereBetween('date', [$monthStart, $monthEnd]);
                        if ($selectedClassId) {
                            $monthAttendanceQuery->where('school_class_id', $selectedClassId);
                        }
                        $monthAttendances = $monthAttendanceQuery->get();
                        
                        $monthPresent = $monthAttendances->where('status', 'present')->count();
                        $monthAbsent = $monthAttendances->where('status', 'absent')->count();
                        $monthTotal = $monthPresent + $monthAbsent;

                        $chartData[] = [
                            'date' => $monthStart->format('M Y'),
                            'present' => $monthPresent,
                            'absent' => $monthAbsent,
                            'present_percentage' => $monthTotal > 0 ? round(($monthPresent / $monthTotal) * 100) : 0,
                            'absent_percentage' => $monthTotal > 0 ? round(($monthAbsent / $monthTotal) * 100) : 0,
                        ];
                    }
                    break;
            }

            // Get exams today
            try {
                $examsToday = Exam::whereDate('exam_date', Carbon::today())->count();
            } catch (\Exception $e) {
                \Log::error('Error fetching exams today: ' . $e->getMessage());
                $examsToday = 0;
            }
            
            // Get active notices count
            try {
                $noticesCount = Notice::active()->count();
                
                // Get recent notices for dashboard
                $recentNotices = Notice::active()
                    ->with('creator')
                    ->latest()
                    ->take(5)
                    ->get();
            } catch (\Exception $e) {
                \Log::error('Error fetching notices: ' . $e->getMessage());
                $noticesCount = 0;
                $recentNotices = collect();
            }
            
            // Get recent activities (new students in last 7 days)
            $recentStudents = Student::where('created_at', '>=', Carbon::now()->subDays(7))->count();
            
            // Get grade statistics
            try {
                $totalGrades = Grade::count();
                $recentGrades = Grade::where('created_at', '>=', Carbon::now()->subDays(7))->count();
                $averageScore = Grade::avg('score') ? round(Grade::avg('score'), 1) : 0;
                
                // Get grade distribution
                $gradeDistribution = Grade::selectRaw('grade, COUNT(*) as count')
                    ->whereNotNull('grade')
                    ->groupBy('grade')
                    ->orderBy('grade')
                    ->get()
                    ->pluck('count', 'grade');
            } catch (\Exception $e) {
                \Log::error('Error fetching grade statistics: ' . $e->getMessage());
                $totalGrades = 0;
                $recentGrades = 0;
                $averageScore = 0;
                $gradeDistribution = collect();
            }
            
            // Get enrollment per class data for charts - optimized with single query
            $enrollmentCounts = Enrollment::selectRaw('class_id, COUNT(*) as student_count')
                ->groupBy('class_id')
                ->pluck('student_count', 'class_id');

            $enrollmentData = [];
            foreach ($classes as $class) {
                $studentCount = $enrollmentCounts->get($class->id, 0);
                $enrollmentData[] = [
                    'class_name' => $class->class_name,
                    'student_count' => $studentCount
                ];
            }

        } catch (\Exception $e) {
            \Log::error('Dashboard data error: ' . $e->getMessage());
            
            // Provide fallback values
            $totalStudents = 0;
            $totalTeachers = 0;
            $totalClasses = 0;
            $femaleStudents = 0;
            $maleStudents = 0;
            $classes = collect();
            $selectedClass = null;
            $selectedClassId = null;
            $studentsInClass = 0;
            $femaleInClass = 0;
            $maleInClass = 0;
            $presentCount = 0;
            $absentCount = 0;
            $presentPercentage = 0;
            $absentPercentage = 0;
            $period = 'weekly';
            $chartData = [];
            $examsToday = 0;
            $noticesCount = 0;
            $recentNotices = collect();
            $recentStudents = 0;
            $enrollmentData = [];
            $totalGrades = 0;
            $recentGrades = 0;
            $averageScore = 0;
            $gradeDistribution = collect();
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
            'enrollmentData',
            'totalGrades',
            'recentGrades',
            'averageScore',
            'gradeDistribution'
        ));
    }
}


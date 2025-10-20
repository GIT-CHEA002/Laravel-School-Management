<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Student;
use App\Models\Grade;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Exam::with(['schoolClass', 'subject']);

        // Filter by class if provided
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        // Filter by subject if provided
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        // Filter by date range if provided
        if ($request->filled('date_from')) {
            $query->whereDate('exam_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('exam_date', '<=', $request->date_to);
        }

        $exams = $query->orderBy('exam_date', 'desc')->paginate(10);
        $classes = SchoolClass::all();
        $subjects = Subject::all();

        return view('admin.exams.index', compact('exams', 'classes', 'subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = SchoolClass::with('subjects')->get();
        $subjects = Subject::all();
        
        return view('admin.exams.create', compact('classes', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'exam_name' => 'required|string|max:255',
            'class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_date' => 'required|date',
            'max_score' => 'required|integer|min:1|max:1000',
        ]);

        Exam::create($validated);

        return redirect()->route('admin.exams.index')->with('success', 'Exam created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Exam $exam)
    {
        $exam->load(['schoolClass', 'subject', 'grades.student']);
        
        // Get students enrolled in this class who don't have grades yet
        $studentsInClass = Student::whereHas('classes', function($query) use ($exam) {
            $query->where('class_id', $exam->class_id);
        })->get();
        
        $studentsWithGrades = $exam->grades->pluck('student_id')->toArray();
        $studentsWithoutGrades = $studentsInClass->whereNotIn('id', $studentsWithGrades);

        return view('admin.exams.show', compact('exam', 'studentsWithoutGrades'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam)
    {
        $classes = SchoolClass::all();
        $subjects = Subject::all();
        
        return view('admin.exams.edit', compact('exam', 'classes', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'exam_name' => 'required|string|max:255',
            'class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_date' => 'required|date',
            'max_score' => 'required|integer|min:1|max:1000',
        ]);

        $exam->update($validated);

        return redirect()->route('admin.exams.index')->with('success', 'Exam updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('admin.exams.index')->with('success', 'Exam deleted successfully.');
    }

    /**
     * Show form to record exam results
     */
    public function showResults(Exam $exam)
    {
        $exam->load(['schoolClass', 'subject', 'grades.student']);
        
        // Get all students in the exam's class
        $students = Student::whereHas('classes', function($query) use ($exam) {
            $query->where('class_id', $exam->class_id);
        })->get();

        return view('admin.exams.results', compact('exam', 'students'));
    }

    /**
     * Store exam results
     */
    public function storeResults(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'grades' => 'required|array',
            'grades.*.student_id' => 'required|exists:students,id',
            'grades.*.score' => 'required|integer|min:0|max:' . $exam->max_score,
        ]);

        foreach ($validated['grades'] as $gradeData) {
            Grade::updateOrCreate(
                [
                    'exam_id' => $exam->id,
                    'student_id' => $gradeData['student_id'],
                ],
                [
                    'score' => $gradeData['score'],
                ]
            );
        }

        return redirect()->route('admin.exams.show', $exam)->with('success', 'Exam results recorded successfully.');
    }
}

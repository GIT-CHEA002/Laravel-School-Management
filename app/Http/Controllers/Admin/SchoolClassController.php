<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = SchoolClass::with(['subjects', 'teacher.user', 'students'])->withCount('students')->paginate(10);
        return view('admin.classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = Teacher::with('user')->get();
        return view('admin.classes.create', compact('teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_name' => 'required|string|max:255',
            'teacher_id' => 'nullable|exists:teachers,id',
            'room_number' => 'nullable|string|max:255',
        ]);

        SchoolClass::create($validated);

        return redirect()->route('admin.classes.index')->with('success', 'Class created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolClass $schoolClass)
    {
        $schoolClass->load(['subjects', 'teachers.user', 'students.user', 'teacher.user']);
        return view('admin.classes.show', compact('schoolClass'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolClass $schoolClass)
    {
        $teachers = Teacher::with('user')->get();
        return view('admin.classes.edit', compact('schoolClass', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolClass $schoolClass)
    {
        $validated = $request->validate([
            'class_name' => 'required|string|max:255',
            'teacher_id' => 'nullable|exists:teachers,id',
            'room_number' => 'nullable|string|max:255',
        ]);

        $schoolClass->update($validated);

        return redirect()->route('admin.classes.index')->with('success', 'Class updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolClass $schoolClass)
    {
        $schoolClass->delete();
        return redirect()->route('admin.classes.index')->with('success', 'Class deleted successfully.');
    }

    /**
     * Show the form for assigning subjects to a class.
     */
    public function assignSubjects(SchoolClass $schoolClass)
    {
        $subjects = Subject::all();
        $teachers = Teacher::with('user')->get();
        $classSubjects = $schoolClass->subjects()->withPivot('teacher_id')->get();
        
        return view('admin.classes.assign-subjects', compact('schoolClass', 'subjects', 'teachers', 'classSubjects'));
    }

    /**
     * Store subjects for a class.
     */
    public function storeSubjects(Request $request, SchoolClass $schoolClass)
    {
        $validated = $request->validate([
            'subjects' => 'required|array',
            'subjects.*.subject_id' => 'required|exists:subjects,id',
            'subjects.*.teacher_id' => 'required|exists:teachers,id',
        ]);

        // First, remove all existing subject assignments for this class
        $schoolClass->subjects()->detach();

        // Add new subject assignments
        foreach ($validated['subjects'] as $subjectData) {
            $schoolClass->subjects()->attach($subjectData['subject_id'], [
                'teacher_id' => $subjectData['teacher_id']
            ]);
        }

        return redirect()->route('admin.classes.show', $schoolClass)->with('success', 'Subjects assigned successfully.');
    }
}

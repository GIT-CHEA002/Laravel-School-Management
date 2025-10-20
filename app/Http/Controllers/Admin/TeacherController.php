<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Teacher::with(['user', 'subjects', 'classes']);

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->whereHas('user', function($userQuery) use ($searchTerm) {
                    $userQuery->where('name', 'like', "%{$searchTerm}%")
                             ->orWhere('email', 'like', "%{$searchTerm}%");
                })
                ->orWhere('first_name', 'like', "%{$searchTerm}%")
                ->orWhere('last_name', 'like', "%{$searchTerm}%")
                ->orWhere('specialization', 'like', "%{$searchTerm}%")
                ->orWhere('phone', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by subject if provided
        if ($request->filled('subject_id')) {
            $query->whereHas('subjects', function($q) use ($request) {
                $q->where('subjects.id', $request->subject_id);
            });
        }

        $teachers = $query->paginate(10);
        $subjects = Subject::all();

        return view('admin.teachers.index', compact('teachers', 'subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'date_of_birth' => $validated['date_of_birth'],
            'gender' => $validated['gender'],
        ]);

        Teacher::create([
            'user_id' => $user->id,
        ]);

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        $teacher->load(['user', 'subjects', 'classes']);

        return view('admin.teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        $teacher->load('user');

        return view('admin.teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $teacher->user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
        ]);

        // Update the user information
        $teacher->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'date_of_birth' => $validated['date_of_birth'],
            'gender' => $validated['gender'],
        ]);

        // Update the teacher information
        $teacher->update([
            'phone' => $validated['phone'],
            'address' => $validated['address'],
        ]);

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        // Delete the associated user
        $teacher->user->delete();
        
        // The teacher will be deleted automatically due to cascade delete or we can delete it explicitly
        $teacher->delete();

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher deleted successfully.');
    }
}

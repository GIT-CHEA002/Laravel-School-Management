<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Subject::withCount(['classes', 'teachers']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('subject_name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%");
        }

        $subjects = $query->orderBy('subject_name')->paginate(15);
        
        return view('admin.subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:subjects,subject_name',
                'code' => 'required|string|max:10|unique:subjects,code',
            ]);

            $subject = Subject::create([
                'subject_name' => trim($validated['name']),
                'code' => strtoupper(trim($validated['code']))
            ]);

            return redirect()->route('admin.subjects.index')
                ->with('success', 'Subject "' . $subject->name . '" created successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create subject: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        $subject->load(['classes', 'teachers.user']);
        return view('admin.subjects.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        return view('admin.subjects.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:subjects,subject_name,' . $subject->id,
                'code' => 'required|string|max:10|unique:subjects,code,' . $subject->id,
            ]);

            $subject->update([
                'subject_name' => trim($validated['name']),
                'code' => strtoupper(trim($validated['code']))
            ]);

            return redirect()->route('admin.subjects.index')
                ->with('success', 'Subject "' . $subject->name . '" updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update subject: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('admin.subjects.index')->with('success', 'Subject deleted successfully.');
    }
}

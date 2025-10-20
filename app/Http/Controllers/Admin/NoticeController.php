<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notices = Notice::with('creator')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.notices.index', compact('notices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.notices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'expires_at' => 'nullable|date|after:now',
            'is_important' => 'boolean',
        ]);

        Notice::create([
            ...$validated,
            'created_by' => auth()->id(),
            'is_important' => $request->boolean('is_important', false),
        ]);

        return redirect()->route('admin.notices.index')->with('success', 'Notice created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Notice $notice)
    {
        $notice->load('creator');
        return view('admin.notices.show', compact('notice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notice $notice)
    {
        return view('admin.notices.edit', compact('notice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notice $notice)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'expires_at' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $notice->update($validated);

        return redirect()->route('admin.notices.index')->with('success', 'Notice updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notice $notice)
    {
        $notice->delete();
        return redirect()->route('admin.notices.index')->with('success', 'Notice deleted successfully.');
    }
}

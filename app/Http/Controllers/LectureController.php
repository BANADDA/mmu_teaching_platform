<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use App\Models\Department;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $lectures = Lecture::with(['department', 'lecturer', 'materials'])->get();
        } else {
            $lectures = auth()->user()->lectures()
                ->with(['department', 'materials'])
                ->get();
        }
        return view('lectures.index', compact('lectures'));
    }

    public function create()
    {
        if (auth()->user()->isAdmin()) {
            $departments = Department::all();
        } else {
            $departments = auth()->user()->departments;
        }
        return view('lectures.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'code'          => 'required|string|unique:lectures',
            'department_id' => 'required|exists:departments,id',
            'description'   => 'nullable|string'
        ]);

        // Check if user has access to this department
        if (!auth()->user()->isAdmin()) {
            $department = Department::find($validated['department_id']);
            if (!$department->users->contains(auth()->id())) {
                abort(403, 'Unauthorized action.');
            }
        }

        $validated['user_id'] = auth()->id();
        Lecture::create($validated);

        return redirect()->route('lectures.index')
            ->with('success', 'Lecture created successfully.');
    }

    public function show(Lecture $lecture)
    {
        if (!auth()->user()->isAdmin() && $lecture->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $lecture->load(['department', 'materials', 'schedules']);
        return view('lectures.show', compact('lecture'));
    }

    public function edit(Lecture $lecture)
    {
        if (!auth()->user()->isAdmin() && $lecture->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if (auth()->user()->isAdmin()) {
            $departments = Department::all();
        } else {
            $departments = auth()->user()->departments;
        }

        return view('lectures.edit', compact('lecture', 'departments'));
    }

    public function update(Request $request, Lecture $lecture)
    {
        if (!auth()->user()->isAdmin() && $lecture->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'code'          => 'required|string|unique:lectures,code,' . $lecture->id,
            'department_id' => 'required|exists:departments,id',
            'description'   => 'nullable|string'
        ]);

        // Check if user has access to this department
        if (!auth()->user()->isAdmin()) {
            $department = Department::find($validated['department_id']);
            if (!$department->users->contains(auth()->id())) {
                abort(403, 'Unauthorized action.');
            }
        }

        $lecture->update($validated);

        return redirect()->route('lectures.index')
            ->with('success', 'Lecture updated successfully.');
    }

    public function destroy(Lecture $lecture)
    {
        if (!auth()->user()->isAdmin() && $lecture->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $lecture->delete();
        return redirect()->route('lectures.index')
            ->with('success', 'Lecture deleted successfully.');
    }
}

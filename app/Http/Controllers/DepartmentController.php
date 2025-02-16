<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    /**
     * Display a listing of departments.
     */
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $departments = Department::with('school')
            ->withCount(['users' => function($query) {
                $query->where('role_id', 2); // Count only lecturers
            }])
            ->orderBy('name')
            ->paginate(10);

        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new department.
     */
    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $schools = School::orderBy('name')->get();
        $lecturers = User::where('role_id', 2)->orderBy('name')->get();

        return view('departments.create', compact('schools', 'lecturers'));
    }

    /**
     * Store a newly created department in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:departments',
            'description' => 'nullable|string',
            'school_id' => 'required|exists:schools,id',
            'lecturer_ids' => 'nullable|array',
            'lecturer_ids.*' => 'exists:users,id'
        ]);

        try {
            DB::beginTransaction();

            $department = Department::create([
                'name' => $validated['name'],
                'code' => $validated['code'],
                'description' => $validated['description'],
                'school_id' => $validated['school_id']
            ]);

            if (!empty($validated['lecturer_ids'])) {
                $department->users()->attach($validated['lecturer_ids']);
            }

            DB::commit();

            return redirect()
                ->route('departments.index')
                ->with('success', 'Department created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to create department. Please try again.');
        }
    }

    /**
     * Display the specified department.
     */
    public function show(Department $department)
{
    if (!auth()->user()->isAdmin()) {
        abort(403);
    }

    $department->load([
        'school',
        'users' => function($query) {
            $query->where('role_id', 2); // Load only lecturers
        },
        'lectures' => function($query) {
            $query->with('user')
                  ->withCount('materials');
        }
    ]);

    return view('departments.show', compact('department'));
}

    /**
     * Show the form for editing the specified department.
     */
    public function edit(Department $department)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $schools = School::orderBy('name')->get();
        $lecturers = User::where('role_id', 2)->orderBy('name')->get();
        $department->load('users');

        return view('departments.edit', compact('department', 'schools', 'lecturers'));
    }

    /**
     * Update the specified department in storage.
     */
    public function update(Request $request, Department $department)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:departments,code,' . $department->id,
            'description' => 'nullable|string',
            'school_id' => 'required|exists:schools,id',
            'lecturer_ids' => 'nullable|array',
            'lecturer_ids.*' => 'exists:users,id'
        ]);

        try {
            DB::beginTransaction();

            $department->update([
                'name' => $validated['name'],
                'code' => $validated['code'],
                'description' => $validated['description'],
                'school_id' => $validated['school_id']
            ]);

            // Sync lecturers
            $department->users()->sync($validated['lecturer_ids'] ?? []);

            DB::commit();

            return redirect()
                ->route('departments.index')
                ->with('success', 'Department updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to update department. Please try again.');
        }
    }

    /**
     * Remove the specified department from storage.
     */
    public function destroy(Department $department)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        try {
            if ($department->lectures()->count() > 0) {
                return back()->with('error', 'Cannot delete department with existing lectures.');
            }

            $department->users()->detach();
            $department->delete();

            return redirect()
                ->route('departments.index')
                ->with('success', 'Department deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete department. Please try again.');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SchoolController extends Controller
{
    /**
     * Display a listing of schools.
     */
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'You must be an admin to access this page.');
        }

        $schools = School::withCount(['departments', 'departments as lecturers_count' => function($query) {
            $query->join('department_user', 'departments.id', '=', 'department_user.department_id')
                  ->join('users', 'department_user.user_id', '=', 'users.id')
                  ->where('users.role_id', 2) // Lecturer role
                  ->select(DB::raw('count(distinct users.id)'));
        }])
        ->orderBy('name')
        ->paginate(10);

        return view('schools.index', compact('schools'));
    }

    /**
     * Show the form for creating a new school.
     */
    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        return view('schools.create');
    }

    /**
     * Store a newly created school in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:schools',
            'description' => 'nullable|string|max:1000'
        ]);

        try {
            $school = School::create($validated);
            Log::info('School created', ['school_id' => $school->id, 'user_id' => auth()->id()]);

            return redirect()
                ->route('schools.index')
                ->with('success', 'School created successfully.');
        } catch (\Exception $e) {
            Log::error('School creation failed', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Failed to create school. Please try again.');
        }
    }

    /**
     * Display the specified school.
     */
    public function show(School $school)
{
    $school->load([
        'departments' => function($query) {
            $query->withCount([
                'users' => function($query) {
                    $query->where('role_id', 2); // Count only lecturers
                },
                'lectures'
            ]);
        }
    ]);

    // Calculate total lecturers
    $lecturersCount = $school->departments->sum(function($department) {
        return $department->users_count;
    });

    return view('schools.show', compact('school', 'lecturersCount'));
}

    /**
     * Show the form for editing the specified school.
     */
    public function edit(School $school)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        return view('schools.edit', compact('school'));
    }

    /**
     * Update the specified school in storage.
     */
    public function update(Request $request, School $school)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:schools,code,' . $school->id,
            'description' => 'nullable|string|max:1000'
        ]);

        try {
            $school->update($validated);
            Log::info('School updated', ['school_id' => $school->id, 'user_id' => auth()->id()]);

            return redirect()
                ->route('schools.index')
                ->with('success', 'School updated successfully.');
        } catch (\Exception $e) {
            Log::error('School update failed', [
                'error' => $e->getMessage(),
                'school_id' => $school->id,
                'user_id' => auth()->id()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Failed to update school. Please try again.');
        }
    }

    /**
     * Remove the specified school from storage.
     */
    public function destroy(School $school)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        try {
            // Check for existing departments
            if ($school->departments()->count() > 0) {
                return back()->with('error', 'Cannot delete school with existing departments.');
            }

            $school->delete();
            Log::info('School deleted', ['school_id' => $school->id, 'user_id' => auth()->id()]);

            return redirect()
                ->route('schools.index')
                ->with('success', 'School deleted successfully.');
        } catch (\Exception $e) {
            Log::error('School deletion failed', [
                'error' => $e->getMessage(),
                'school_id' => $school->id,
                'user_id' => auth()->id()
            ]);

            return back()->with('error', 'Failed to delete school. Please try again.');
        }
    }
}

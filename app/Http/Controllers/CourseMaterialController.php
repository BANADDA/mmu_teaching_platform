<?php

namespace App\Http\Controllers;

use App\Models\CourseMaterial;
use App\Models\Lecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseMaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $materials = CourseMaterial::with('lecture')->get();
        } else {
            $materials = CourseMaterial::whereHas('lecture', function ($query) {
                $query->where('user_id', auth()->id());
            })->with('lecture')->get();
        }
        return view('materials.index', compact('materials'));
    }

    public function create()
    {
        if (auth()->user()->isAdmin()) {
            $lectures = Lecture::all();
        } else {
            $lectures = auth()->user()->lectures;
        }
        return view('materials.create', compact('lectures'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'description'=> 'nullable|string',
            'file'       => 'required|file|max:10240', // 10 MB limit
            'lecture_id' => 'required|exists:lectures,id',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('course_materials', 'public');
            $validated['file_path'] = $path;
            $validated['file_type'] = $request->file('file')->getClientOriginalExtension();
        }

        CourseMaterial::create($validated);

        return redirect()->route('materials.index')->with('success', 'Course material created successfully.');
    }

    public function show(string $id)
    {
        $material = CourseMaterial::findOrFail($id);
        return view('materials.show', compact('material'));
    }

    public function edit(string $id)
    {
        $material = CourseMaterial::findOrFail($id);

        if (auth()->user()->isAdmin()) {
            $lectures = Lecture::all();
        } else {
            $lectures = auth()->user()->lectures;
        }

        return view('materials.edit', compact('material', 'lectures'));
    }

    public function update(Request $request, string $id)
    {
        $material = CourseMaterial::findOrFail($id);

        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'description'=> 'nullable|string',
            'file'       => 'nullable|file|max:10240', // 10 MB limit
            'lecture_id' => 'required|exists:lectures,id',
        ]);

        if ($request->hasFile('file')) {
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }
            $path = $request->file('file')->store('course_materials', 'public');
            $validated['file_path'] = $path;
            $validated['file_type'] = $request->file('file')->getClientOriginalExtension();
        }

        $material->update($validated);

        return redirect()->route('materials.index')->with('success', 'Course material updated successfully.');
    }

    public function destroy(string $id)
    {
        $material = CourseMaterial::findOrFail($id);

        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return redirect()->route('materials.index')->with('success', 'Course material deleted successfully.');
    }
}

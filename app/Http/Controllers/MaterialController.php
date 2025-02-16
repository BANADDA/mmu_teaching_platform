<?php

namespace App\Http\Controllers;

use App\Models\CourseMaterial;
use App\Models\Lecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
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
            'file'       => 'required|file|max:10240', // 10MB limit
            'lecture_id' => 'required|exists:lectures,id',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('course_materials', 'public');
            $validated['file_path'] = $path;
        }

        CourseMaterial::create($validated);

        return redirect()->route('materials.index')->with('success', 'Material created successfully.');
    }

    public function show(CourseMaterial $material)
    {
        return view('materials.show', compact('material'));
    }

    public function edit(CourseMaterial $material)
    {
        if (auth()->user()->isAdmin()) {
            $lectures = Lecture::all();
        } else {
            $lectures = auth()->user()->lectures;
        }
        return view('materials.edit', compact('material', 'lectures'));
    }

    public function update(Request $request, CourseMaterial $material)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'description'=> 'nullable|string',
            'file'       => 'nullable|file|max:10240', // 10MB limit
            'lecture_id' => 'required|exists:lectures,id',
        ]);

        if ($request->hasFile('file')) {
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }
            $path = $request->file('file')->store('course_materials', 'public');
            $validated['file_path'] = $path;
        }

        $material->update($validated);

        return redirect()->route('materials.index')->with('success', 'Material updated successfully.');
    }

    public function destroy(CourseMaterial $material)
    {
        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }
        $material->delete();

        return redirect()->route('materials.index')->with('success', 'Material deleted successfully.');
    }
}

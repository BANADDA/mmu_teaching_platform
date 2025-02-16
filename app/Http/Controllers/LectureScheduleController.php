<?php

namespace App\Http\Controllers;

use App\Models\LectureSchedule;
use App\Models\Lecture;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $schedules = LectureSchedule::with('lecture')->get();
        } else {
            $schedules = LectureSchedule::whereHas('lecture', function ($query) {
                $query->where('user_id', auth()->id());
            })->with('lecture')->get();
        }
        return view('schedules.index', compact('schedules'));
    }

    public function create()
    {
        if (auth()->user()->isAdmin()) {
            $lectures = Lecture::all();
        } else {
            $lectures = auth()->user()->lectures;
        }
        return view('schedules.create', compact('lectures'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lecture_id'   => 'required|exists:lectures,id',
            'start_time'   => 'required|date_format:Y-m-d H:i:s',
            'end_time'     => 'required|date_format:Y-m-d H:i:s|after:start_time',
            'venue'        => 'nullable|string|max:255',
            'notes'        => 'nullable|string',
            'type'         => 'required|in:physical,online',
            'meeting_link' => 'nullable|url',
        ]);

        LectureSchedule::create($validated);

        return redirect()->route('schedules.index')->with('success', 'Schedule created successfully.');
    }

    public function show(string $id)
    {
        $schedule = LectureSchedule::findOrFail($id);
        return view('schedules.show', compact('schedule'));
    }

    public function edit(string $id)
    {
        $schedule = LectureSchedule::findOrFail($id);

        if (auth()->user()->isAdmin()) {
            $lectures = Lecture::all();
        } else {
            $lectures = auth()->user()->lectures;
        }

        return view('schedules.edit', compact('schedule', 'lectures'));
    }

    public function update(Request $request, string $id)
    {
        $schedule = LectureSchedule::findOrFail($id);

        $validated = $request->validate([
            'lecture_id'   => 'required|exists:lectures,id',
            'start_time'   => 'required|date_format:Y-m-d H:i:s',
            'end_time'     => 'required|date_format:Y-m-d H:i:s|after:start_time',
            'venue'        => 'nullable|string|max:255',
            'notes'        => 'nullable|string',
            'type'         => 'required|in:physical,online',
            'meeting_link' => 'nullable|url',
        ]);

        $schedule->update($validated);

        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroy(string $id)
    {
        $schedule = LectureSchedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully.');
    }
}

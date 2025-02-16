<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use App\Models\Department;
use App\Models\Lecture;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [];

        if (auth()->user()->isAdmin()) {
            $data = [
                'schoolsCount' => School::count(),
                'departmentsCount' => Department::count(),
                'lecturesCount' => Lecture::count(),
                'materialsCount' => DB::table('course_materials')->count(),
                'lecturersCount' => User::where('role_id', 2)->count(), // Assuming 2 is lecturer role_id
                'calendarEvents' => $this->getCalendarEvents(),
                'recentActivities' => $this->getRecentActivities()
            ];
        } else {
            $userId = auth()->id();
            $data = [
                'myLecturesCount' => Lecture::where('user_id', $userId)->count(),
                'myDepartmentsCount' => DB::table('department_user')
                    ->where('user_id', $userId)
                    ->count(),
                'materialsCount' => DB::table('course_materials')
                    ->whereIn('lecture_id', function($query) use ($userId) {
                        $query->select('id')
                            ->from('lectures')
                            ->where('user_id', $userId);
                    })->count(),
                'upcomingCount' => DB::table('lecture_schedules')
                    ->whereIn('lecture_id', function($query) use ($userId) {
                        $query->select('id')
                            ->from('lectures')
                            ->where('user_id', $userId);
                    })
                    ->where('start_time', '>', now())
                    ->count(),
                'calendarEvents' => $this->getCalendarEvents($userId),
                'recentActivities' => $this->getRecentActivities($userId)
            ];
        }

        return view('dashboard', $data);
    }

    private function getCalendarEvents($userId = null)
    {
        $query = DB::table('lecture_schedules')
            ->join('lectures', 'lectures.id', '=', 'lecture_schedules.lecture_id')
            ->select([
                'lectures.name as title',
                'lecture_schedules.start_time as start',
                'lecture_schedules.end_time as end',
                'lecture_schedules.type',
                'lectures.id as lecture_id'
            ])
            ->where('start_time', '>', now());

        if ($userId) {
            $query->where('lectures.user_id', $userId);
        }

        return $query->get()->map(function($event) {
            return [
                'title' => $event->title,
                'start' => $event->start,
                'end' => $event->end,
                'url' => route('lectures.show', $event->lecture_id),
                'backgroundColor' => $event->type === 'online' ? '#4F46E5' : '#059669'
            ];
        });
    }

    private function getRecentActivities($userId = null)
    {
        $activities = collect();

        // Get recent lectures
        $query = DB::table('lectures')
            ->select('name', 'created_at', DB::raw("'lecture' as type"))
            ->orderBy('created_at', 'desc');

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $activities = $activities->merge($query->limit(5)->get());

        // Get recent materials
        $query = DB::table('course_materials')
            ->join('lectures', 'lectures.id', '=', 'course_materials.lecture_id')
            ->select('course_materials.title as name', 'course_materials.created_at', DB::raw("'material' as type"));

        if ($userId) {
            $query->where('lectures.user_id', $userId);
        }

        $activities = $activities->merge($query->limit(5)->get())
            ->sortByDesc('created_at')
            ->take(5)
            ->map(function($activity) {
                return [
                    'description' => "New {$activity->type} '{$activity->name}' was created",
                    'time' => \Carbon\Carbon::parse($activity->created_at)->diffForHumans(),
                    'type' => $activity->type
                ];
            });

        return $activities;
    }
}

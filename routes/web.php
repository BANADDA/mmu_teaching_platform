<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\MyDepartmentController;
use App\Http\Controllers\MyLectureController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Welcome/Landing page
Route::get('/', function () {
    return view('pages.welcome');
});

// Debug route for checking user role
Route::get('/check-role', function() {
    $user = auth()->user();
    dd([
        'user_id' => $user->id,
        'role_id' => $user->role_id,
        'is_admin' => $user->isAdmin(),
        'all_user_data' => $user->toArray()
    ]);
})->middleware('auth');

// Protected routes that require authentication
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::prefix('profile')->group(function() {
        Route::get('/', [ProfileController::class, 'show'])->name('profile.show');
        Route::put('/', [ProfileController::class, 'update'])->name('profile.update');
    });

    // Admin routes
    Route::middleware(['auth'])->group(function () {
        // Schools Management
        Route::resource('schools', SchoolController::class);

        // Departments Management
        Route::resource('departments', DepartmentController::class);

        // Users Management
        Route::resource('users', UserController::class);

        // Settings
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    });

    // Lecturer routes
    Route::middleware(['auth'])->group(function () {
        // My Departments
        Route::resource('my-departments', MyDepartmentController::class);

        // My Lectures
        Route::resource('my-lectures', MyLectureController::class);
    });

    // Shared resources (access controlled in controllers)
    Route::resources([
        'lectures' => LectureController::class,
        'materials' => MaterialController::class,
        'schedules' => ScheduleController::class,
    ]);

    // API routes for dashboard data
    Route::prefix('api')->group(function () {
        Route::get('/calendar-events', [DashboardController::class, 'getCalendarEvents']);
        Route::get('/statistics', [DashboardController::class, 'getStatistics']);
        Route::get('/recent-activities', [DashboardController::class, 'getRecentActivities']);
    });
});

// Fallback route for 404
Route::fallback(function () {
    return view('errors.404');
});

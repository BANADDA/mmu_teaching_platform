<?php
// app/Http/Middleware/RoleMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->isAdmin()) {
            // Admin can access everything
            return $next($request);
        }

        if (auth()->user()->isLecturer()) {
            // For lecturers, check if they're accessing their own resources
            $route = $request->route();
            $routeName = $route->getName();

            // If accessing lecture-related routes, verify ownership
            if (str_contains($routeName, 'lectures')) {
                $lectureId = $route->parameter('lecture');
                if ($lectureId && !auth()->user()->lectures()->where('id', $lectureId)->exists()) {
                    abort(403, 'Unauthorized access.');
                }
            }
        }

        return $next($request);
    }
}

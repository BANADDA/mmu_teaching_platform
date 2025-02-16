<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot(): void
    {
        Gate::define('isAdmin', function($user) {
            // Add logging to debug
            Log::info('Checking isAdmin gate', [
                'user_id' => $user->id,
                'role_id' => $user->role_id,
                'is_admin' => $user->role_id === 1
            ]);

            return $user->role_id === 1;
        });

        Gate::define('isLecturer', function($user) {
            return $user->role_id === 2;
        });

        // Add a before callback to log all gate checks
        Gate::before(function ($user, $ability) {
            Log::info('Gate check', [
                'user_id' => $user->id,
                'ability' => $ability,
                'role_id' => $user->role_id
            ]);

            return null; // Continue with normal gate check
        });
    }
}

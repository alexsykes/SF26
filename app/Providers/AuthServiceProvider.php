<?php

namespace App\Providers;

use App\Policies\NotePolicy;
use Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        Gate::define('manage_users', function (User $user) {
            return $user->role == "admin";
        });

        /* define a admin user role */
        Gate::define('isAdmin', function ($user) {
            return $user->role == 'admin';
        });

        /* define a manager user role */
        Gate::define('isEditorOrAbove', function ($user) {
            return ($user->isEditor || $user->isSuperUser);

        });

        /* define a logged in user role */
        Gate::define('isLoggedInUser', function ($user) {
            return Auth::check();
        });
    }
}

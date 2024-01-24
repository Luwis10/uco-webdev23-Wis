<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Enums\UserRoleEnum;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('isAdmin', function ($user) {
            return $user->role->value === UserRoleEnum::Administrator->value;
        });
        Gate::define('isAuthor', function ($user) {
            return $user->role->value === UserRoleEnum::Author->value;
        });
    }
}

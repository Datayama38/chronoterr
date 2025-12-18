<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\Permission;
use App\Observers\RoleObserver;
use App\Observers\PermissionObserver;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bindings / singletons uniquement
    }

    public function boot(): void
    {
        $this->configureRateLimiting();
        $this->configureAuthorization();
        Role::observe(RoleObserver::class);
        Permission::observe(PermissionObserver::class);
    }

    private function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(240)
                ->by($request->user()?->id ?? $request->ip());
        });
    }

    private function configureAuthorization(): void
    {
        if (! Schema::hasTable('roles')) {
            return;
        }

        // Cache permanent — invalidation manuelle requise
        $roles = cache()->rememberForever('roles_permissions', function () {
            return Role::with('permissions:id,slug')->get(['id']);
        });

        $permissionsRolesMap = [];

        foreach ($roles as $role) {
            foreach ($role->permissions as $permission) {
                $permissionsRolesMap[$permission->slug][] = $role->id;
            }
        }

        foreach ($permissionsRolesMap as $slug => $roleIds) {
            Gate::define($slug, fn ($user) =>
                $user->role
                    ->pluck('id')
                    ->intersect($roleIds)
                    ->isNotEmpty()
            );
        }
    }
}

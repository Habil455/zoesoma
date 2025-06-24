<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use Exception;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
{
    $this->registerPolicies();

    try {
        $permissions = DB::table('permissions')->get();

        if ($permissions->isEmpty()) {
            session()->flash("error", "No permissions found in database");
            return;
        }

        foreach ($permissions as $permission) {
            Gate::define($permission->slug, function ($user) use ($permission) {
                return $user->roles()->whereHas('permissions', function ($query) use ($permission) {
                    $query->where('slug', $permission->slug);
                })->exists();
            });
        }
    } catch (\Exception $e) {
        session()->flash("error", "Error fetching roles and permissions: " . $e->getMessage());
    }
}
}

<?php

namespace App\Providers;

use App\Models\CompanyInformation;
use App\Models\Draft;
use App\Models\User;
use App\Policies\DraftPolicy;
use App\Policies\PostPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        CompanyInformation::class => PostPolicy::class, // 投稿
        Draft::class => DraftPolicy::class // 下描き
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function (User $user) {
            return $user->privilege == 2;
        });
    }
}

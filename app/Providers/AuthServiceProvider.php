<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //  'App\ExpenseCategory' => 'App\Policies\ExpenseCategoryPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('view-dashboard', function($user){
            return $user->isAdmin();
        });
        Gate::define('view-expense', function($user, $expense){
            return ($user->isAdmin() || $user->id == $expense->user->id);
        });

        Gate::define('can-view-user', function($user, $user_record){ 
            return $user->isAdmin() || $user->id == $user_record->id;
        });
        Gate::define('can-create-user', function($user){
            return $user->isAdmin();
        });

        Gate::define('can-update-user', function($user, $user_record){
            return $user->isAdmin() || $user->id == $user_record->id;
        });

        Gate::define('can-delete-user', function($user){
            return $user->isAdmin();
        });

        Gate::define('can-create-expense', function($user){
            return true;
        });

        Gate::define('can-delete-expense', function($user){
            return true;
        });

        Gate::define('can-update-expense', function($user){
            return true;
        });

        Gate::define('can-create-expense-category', function($user){
            return $user->isAdmin();
        });

        Gate::define('can-update-expense-category', function($user){
            return $user->isAdmin();
        });

        Gate::define('can-delete-expense-category', function($user){
            return $user->isAdmin();
        });

        Gate::define('can-view-user-management', function($user){
            return $user->isAdmin();
        });

        Gate::define('can-change-password', function($user){
            return (!$user->isAdmin() || $user->id == Auth::user()->id);
        });
        
    }
}

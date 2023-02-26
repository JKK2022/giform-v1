<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        Gate::define('admin',function(User $user){
            return $user->hasRole("admin");
        });

        Gate::define('formateur',function(User $user){
            return $user->hasRole("formateur");
        });

        Gate::define('chefservice',function(User $user){
            return $user->hasRole("Chef de service");
        });

        Gate::define('caisseprincipale',function(User $user){
            return $user->hasRole("Caisse principale");
        });

        Gate::define('caissetechnique',function(User $user){
            return $user->hasRole("Caisse technique");
        });

        Gate::define('caisserecouvrement',function(User $user){
            return $user->hasRole("Caisse recouvrement");
        });

        Gate::define('aaf',function(User $user){
            return $user->hasRole("Adjoint Administratif et Financier");
        });

        Gate::define('at',function(User $user){
            return $user->hasRole("Adjoint Technique");
        });

        Gate::define('dp',function(User $user){
            return $user->hasRole("Directeur Provincial");
        });

        Gate::define('conseillerprincipal',function(User $user){
            return $user->hasRole("Conseiller principal");
        });

        Gate::define('conseiller',function(User $user){
            return $user->hasRole("Conseiller en formation");
        });

        Gate::before(function(User $user){
            // if($user->hasRole("Super admin")){
            //     return true;
            // }

            return $user->hasRole("Super admin");
        });
    }
}

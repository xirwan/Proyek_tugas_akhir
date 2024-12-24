<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Pagination\Paginator;

use Illuminate\Support\Facades\Gate;

use App\Models\User;

use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {   
        // Menambahkan pengecualian untuk Super Admin
        Gate::before(function ($user, $ability) {
            return $user->hasRole('SuperAdmin') ? true : null;
        });
        
        Paginator::useBootstrapFive();
        //diaktifkan saat menggunakan ngrok
        // if(config('app.env') === 'local'){
        //     URL::forceScheme('https');
        // }
        

    }
}

<?php

namespace App\Providers;

use App\Models\User;
use App\Models\CompanySetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;

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
        // Mencegah penghapusan admin terakhir
        User::deleting(function ($user) {
            if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
                return false;
            }
            return true;
        });
        Paginator::useBootstrapFive();

        // Share company profile globally
        View::share('company', CompanySetting::firstOrCreate(
            ['id' => 1],
            ['name' => 'TB. SOGOL ANUGRAH MANDIRI']
        ));

        // Notification View Composer
        View::composer('layouts.navbar', \App\Http\View\Composers\NotificationComposer::class);
    }
}
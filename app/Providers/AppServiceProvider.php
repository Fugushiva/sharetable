<?php

namespace App\Providers;

use App\View\Composers\LanguageComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
     * Register the LanguageComposer to the navigation and profile.edit views
     */
    public function boot(): void
    {
        View::composer(['layouts.navigation', 'profile.edit'], LanguageComposer::class);
    }
}

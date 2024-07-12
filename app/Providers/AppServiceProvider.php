<?php

namespace App\Providers;

use App\View\Composers\LanguageComposer;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->from('jerome@sharetable.com', 'ShareTable')
                ->subject(__('mail.verify_email_address'))
                ->line(__('mail.confirm_email_action'))
                ->line(__('mail.verify_button'))
                ->action(__('mail.verify_button'), $url);
        });

        $this->loadMigrationsFrom(__DIR__.'/../../vendor/nnjeim/world/src/Database/Migrations');
        View::composer(['layouts.navigation', 'profile.edit'], LanguageComposer::class);

    }
}

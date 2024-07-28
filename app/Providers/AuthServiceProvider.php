<?php

namespace App\Providers;

use App\Models\Host;
use App\Models\Message;
use App\Models\Reservation;
use App\Policies\HostPolicy;
use App\Policies\MessagePolicy;
use App\Policies\ReservationPolicy;
use App\Policies\ThreadPolicy;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Annonce;
use App\Policies\AnnoncePolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Annonce::class => AnnoncePolicy::class,
        Host::class => HostPolicy::class,
        Reservation::class => ReservationPolicy::class,
        Message::class => MessagePolicy::class,
        Thread::class => ThreadPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        View::composer('*', function ($view) {
            $unreadCount = 0;
            if (Auth::check()) {
                $unreadCount = Thread::forUser(Auth::id())->whereHas('messages', function ($query) {
                    $query->where('is_read', false)
                        ->where('user_id', '!=', Auth::id());
                })->count();
            }
            $view->with('unreadCount', $unreadCount);
        });


    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetUserLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // on récupère la langue de la session
        $language = session('locale', config('app.locale'));

        // si l'utilisateur est connecté, on récupère sa langue
        if(Auth::check() ){
            $language = session('locale', Auth::user()->language->code);
        }

        App::setLocale($language);

        return $next($request);
    }
}

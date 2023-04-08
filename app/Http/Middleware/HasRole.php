<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class HasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, string $roleName)
    {
        // check se l'utente è autenticato
        if(!Auth::check()) {
            return redirect('login');
        }

        // user authenticated
        $user = Auth::user();

        // format roleName prima lettera maiuscola
        $roleName = ucfirst($roleName);

        // check se l'utente non ha il ruolo
        if(!$user->hasRole($roleName)) {
            abort(403, 'Accesso non autorizzato');
        }

        return $next($request);
    }
}

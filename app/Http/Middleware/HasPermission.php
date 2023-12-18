<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class HasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, string $permissionName)
    {
        // check user is authenticated
        if(!Auth::check()) {
            return redirect('login');
        }

        // auth user
        $user = Auth::user();

        // format permissionName
        $permissionName = strtolower($permissionName);

        // check user not has permission
        if(!$user->hasPermission($permissionName)) { 
            abort(403, 'Non Hai i Permessi per accedere');
        }
        
        return $next($request);
    }
}

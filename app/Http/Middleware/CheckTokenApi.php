<?php

namespace App\Http\Middleware;

use Closure;
use Hash;

class CheckTokenApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // controllo se esiste il parametro Authorization
        if(!$request->header('Authorization')) {
            return response()->json([
                'status' => 422,
                'message' => 'Header Authorization is required.',
            ], 422);
        }

        // controllo se il parametro richiesta Authorization corrisponde a quello nel db in hash
        if(!Hash::check(config('app.api_token'), $request->header('Authorization'))) {
            return response()->json([
                'status' => 401,
                'message' => 'Header Authorization is invalid.'
            ], 401);
        }

        return $next($request);
    }
}

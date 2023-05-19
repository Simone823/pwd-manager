<?php

namespace App\Http\Middleware;

use App\PersonalAccessApiToken;
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
        // controllo se esiste il parametro Api_Token
        if(!$request->has('Api_Token')) {
            return response()->json([
                'status' => 422,
                'message' => 'Param Api_Token is required.',
            ], 422);
        }

        // controllo se il parametro richiesta Api_Token corrisponde a quello nel db in hash
        if(!Hash::check(config('app.api_token'), $request->Api_Token)) {
            return response()->json([
                'status' => 401,
                'message' => 'Param Api_Token is invalid.'
            ], 401);
        }

        return $next($request);
    }
}

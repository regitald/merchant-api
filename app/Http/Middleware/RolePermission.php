<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware as Middleware;

class RolePermission extends Middleware
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
        $user = JWTAuth::parseToken()->authenticate();
        if($user->role_id != 1) {
            return response()->json(['status' => false,'code' => 402,'message' => 'You are not allowed to access this menu'],402);
        }
        return $next($request);
    }
}

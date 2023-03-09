<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddlewareTechnical extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $payload = JWTAuth::parseToken()->getPayload();
        $role = $payload->get('role');

        if($role != 2) {
            return response()->json(["status" => 403, "message" => "No tienes permiso para acceder a este recurso"]);
        }

        return $next($request);
    }
}

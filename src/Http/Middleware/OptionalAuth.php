<?php

namespace Lugmety\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OptionalAuth
{
    public function handle(Request $request, Closure $next, $permission = ""): Response
    {
        if($request->header('authorization') || $request->has('access_token')){
            return app()->make(Authenticate::class)->handle($request, $next, $permission);
        }

        // continue the request
        return $next($request);
    }
}

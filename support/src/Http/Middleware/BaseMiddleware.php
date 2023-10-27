<?php

namespace Grilar\Support\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BaseMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}

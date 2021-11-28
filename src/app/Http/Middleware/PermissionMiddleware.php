<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     * @param $request
     * @param Closure $next
     * @param $ermission
     * @return mixed
     */
    public function handle($request, Closure $next,$permission)
    {
        if(!auth()->user()->hasPermissionTo($permission)) {
            return response()->json([
                "status"    =>  false,
                "message"   =>  "You don't have permission to see"
            ],Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}

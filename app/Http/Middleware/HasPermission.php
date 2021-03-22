<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $scope)
    {
        if (Auth::user()->hasPermission($scope)) {
            return $next($request);
        } else {
            return abort(403, "you don't have required permissions to confirm this action");
        }
    }
}

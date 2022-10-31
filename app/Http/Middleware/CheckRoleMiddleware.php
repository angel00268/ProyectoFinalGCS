<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,string $permission)
    {
        if ($permission == 'user' && !auth()->user()->is_admin && auth()->user()->user_detail->role == "Investigador") {
            abort(403, 'Usted no tiene permisos para estar aqui.');
        }
        if ($permission == 'profile' && auth()->user()->is_admin) {
            abort(403, 'Usted no tiene permisos para estar aqui.');
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                // Si admin connecté → redirige vers dashboard
                if ($guard === 'admin' || $request->is('admin/*')) {
                    return redirect('/admin/dashboard');
                }

                // Si agent connecté → redirige vers dashboard agent
               if ($guard === 'agent' || $request->is('agent/*')) {
                return redirect('/agent/dashboard');
               }

                // Si utilisateur connecté → redirige vers home
                return redirect('/dashboard');
            }
        }

        return $next($request);
    }
}
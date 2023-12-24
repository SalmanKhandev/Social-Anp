<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super-Admin')) {
                    // If the user has 'admin' or 'super-admin' role, redirect to 'admin.dashboard'.
                    return redirect()->route('admin.dashboard');
                }

                // if (auth()->user()->hasRole('User')) {

                //     // If the user has 'admin' or 'super-admin' role, redirect to 'admin.dashboard'.
                //     return redirect()->route('users.dashboard');
                // }


                // If the user doesn't have 'admin' or 'super-admin' role, redirect to 'user.dashboard'.
            }
        }

        // If no guards were provided or no user is authenticated, continue with the request.
        return $next($request);
    }
}

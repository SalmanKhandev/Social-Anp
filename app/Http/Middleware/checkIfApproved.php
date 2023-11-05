<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class checkIfApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $role = Auth::user()->hasRole('User');
        if ($role && auth()->check() && auth()->user()->status !== 1) {
            // Redirect only if the user is not already on the 'login' route
            if ($request->routeIs('login')) {
                return $next($request);
            }
            return redirect()->route('login')->with('message', 'You are registered successfully please wait until Admin approve your account !');
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (auth()->check() && auth()->user()->status !== 1) {
            return redirect()->route('login');
        }

        return $request->expectsJson() ? null : route('login');
    }
}

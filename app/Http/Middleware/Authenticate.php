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
        // For API/json requests, do not redirect (return null) so a JSON 401 is returned.
        if ($request->expectsJson()) {
            return null;
        }

        // For non-API requests, return the named login route if available.
        // If your app does not have a web login route, returning null is also acceptable.
        return route('login');
    }
}

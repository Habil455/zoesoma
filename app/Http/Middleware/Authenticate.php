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
        if (! $request->expectsJson()) {
        // Redirect customers to their login page
        if ($request->is('customer') || $request->is('customer/*')) {
            return route('customer.login'); // e.g. /customer/login
        }

        // Default redirect for staff/supervisors
        return route('login'); // e.g. /login
    }

    return null;
    }
}

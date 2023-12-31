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
        if ($request->expectsJson()) {
            return null;
        } else {
            if (str_contains($_SERVER['REQUEST_URI'], 'pro-admin')) {
                return route('admin.login');
            } else {
                return null;
            }
        }
    }
}

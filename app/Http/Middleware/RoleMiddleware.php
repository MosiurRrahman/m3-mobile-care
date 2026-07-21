<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check if the user's role is in the allowed roles list
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Redirect back with an error or show 403 Forbidden
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this module.');
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $feature): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!auth()->user()->hasPermissionTo($feature)) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'You do not have permission to perform this action.'], 403);
            }
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access that feature.');
        }

        return $next($request);
    }
}

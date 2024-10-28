<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!$request->user() || !$request->user()->role) {
            abort(403, 'Unauthorized action.');
        }

        $userRole = $request->user()->role;

        // Simplify role checking logic
        if (is_string($userRole)) {
            // Handle JSON string case
            if (json_decode($userRole) !== null) {
                $userRole = json_decode($userRole, true);
                if (isset($userRole['role']) && $userRole['role'] === $role) {
                    return $next($request);
                }
            }
            // Handle plain string case
            else if ($userRole === $role) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized action.');
    }
}
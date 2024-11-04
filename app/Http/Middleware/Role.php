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
        if ($request->user()->role == $role) {
            return $next($request);
        }


        $userRole = $request->user()->role;
        if (json_decode($userRole)) {
            $userRole = json_decode($userRole, true);
            if ($userRole['role'] == $role) {
                return $next($request);
            }
        }



        // Tindakan jika pengguna tidak memiliki peran yang diperlukan
        abort(403, 'Unauthorized');
    }
}
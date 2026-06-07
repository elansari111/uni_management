<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthenticated. Please login to continue.',
                ], 401);
            }
            return redirect()->guest(route('login'))->with('error', 'Please login to continue.');
        }

        foreach ($roles as $role) {
            if ($request->user()->hasRole($role)) {
                return $next($request);
            }
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Unauthorized. You do not have the required role.',
                'required_roles' => $roles,
                'user_role' => $request->user()->role?->slug,
            ], 403);
        }

        abort(403, 'Unauthorized. You do not have the required role.');
    }
}

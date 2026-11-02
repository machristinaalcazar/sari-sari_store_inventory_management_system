<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Check if user is authenticated
        if (!$request->user()) {
            return response()->json([
                'success' => false,
                'status'  => 'error',
                'message' => 'Unauthorized: No token provided or user not authenticated.'
            ], 401);
        }

        // Check if the user's role matches any of the allowed roles
        if (!empty($roles) && !in_array($request->user()->role, $roles)) {
            return response()->json([
                'success' => false,
                'status'  => 'error',
                'message' => 'Unauthorized: Access restricted. Required role(s): ' . implode(', ', $roles) . '.'
            ], 403);
        }

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StaffMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in and has a staff or admin role
        $user = $request->user();
        
        if (!$user || !in_array($user->role, ['staff', 'admin'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. Staff or Admin access required.'
            ], 403);
        }

        return $next($request);
    }
}
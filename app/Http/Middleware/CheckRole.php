<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {
         // Check if user is authenticated
         if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Get the authenticated user
        $users = Auth::user()->role;

        // Check if the user has any of the required roles
        foreach ($users as $user) {
            if ($user->role->name == $roles) {
                return $next($request);
            }
            else{
                return 'failed';
            }
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }
}

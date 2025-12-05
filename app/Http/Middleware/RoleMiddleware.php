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
     * 
     * Usage: Route::middleware(['auth', 'role:admin,doctor'])->group(...)
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check if user has any of the required roles
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Redirect based on their actual role
        return redirect()->route($this->getRedirectRoute($user->role))
            ->with('error', 'You do not have permission to access this page.');
    }

    /**
     * Get the redirect route based on user role
     */
    private function getRedirectRoute($role): string
    {
        return match($role) {
            'admin' => 'admin.dashboard',
            'doctor' => 'admin.dashboard',
            'nurse' => 'admin.dashboard',
            default => 'login',
        };
    }
}
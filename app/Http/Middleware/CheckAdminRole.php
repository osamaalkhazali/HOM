<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $admin = auth('admin')->user();

        if (!$admin) {
            return redirect()->route('admin.login')->with('error', 'Please login to continue.');
        }

        // Check if admin has any of the required roles
        $hasRole = false;
        foreach ($roles as $role) {
            if ($role === 'super' && $admin->isSuperAdmin()) {
                $hasRole = true;
                break;
            }
            if ($role === 'admin' && $admin->isAdmin()) {
                $hasRole = true;
                break;
            }
            if ($role === 'client_hr' && $admin->isClientHr()) {
                $hasRole = true;
                break;
            }
        }

        if (!$hasRole) {
            abort(403, 'You do not have permission to access this resource.');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPasswordExpiry
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->password_changed_at) {
            $expired = $user->password_changed_at->diffInMonths(now()) >= 6;

            if ($expired && !$request->routeIs('password.expired', 'password.expired.update', 'logout')) {
                return redirect()->route('password.expired');
            }
        }

        return $next($request);
    }
}

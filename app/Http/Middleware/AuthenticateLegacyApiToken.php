<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Authenticates requests from the existing Android application, which
 * sends the token issued at /api/login as a "token" query/body parameter
 * (and nothing else). Kept only for the transition period.
 */
class AuthenticateLegacyApiToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->input('token') ?: $request->bearerToken();
        if (! $token) {
            return response()->json(['success' => false, 'error' => 'Unauthorized access.'], 401);
        }

        $user = User::where('api_token', $token)->first();
        if (! $user) {
            return response()->json(['success' => false, 'error' => 'Invalid Token passed.'], 401);
        }
        if (! $user->hasAnyRole([User::ROLE_COLLECTOR, User::ROLE_PARTNER])) {
            return response()->json(['success' => false, 'error' => 'User is not having a valid role'], 401);
        }
        if (! $user->is_active) {
            return response()->json(['success' => false, 'error' => 'Your account is inactive'], 401);
        }

        Auth::setUser($user);
        $request->setUserResolver(fn () => $user);

        return $next($request);
    }
}

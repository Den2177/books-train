<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::firstWhere('token', $request->bearerToken());

        if (!$user) {
            return response()->json(
                [
                    'error' => [
                        'code' => 403,
                        'message' => 'Login failed',
                    ]
                ], 403
            );
        }

        Auth::login($user);

        return $next($request);
    }
}

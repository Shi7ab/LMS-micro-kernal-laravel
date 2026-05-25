<?php

namespace Kernal\Middelware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthMiddelware
{
    public function handle(Request $request, Closure $next)
    {
        try {

            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            }

            auth()->setUser($user);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        return $next($request);
    }
}

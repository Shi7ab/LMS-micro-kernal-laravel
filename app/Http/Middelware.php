<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\DB;

class JwtAuthMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json(['error' => 'Unauthorized. Token missing.'], 401);
        }

        $token = str_replace('Bearer ', '', $authHeader);

        try {
            // Decode securely using token key from configurations
            $decoded = JWT::decode($token, new Key(config('app.key'), 'HS256'));

            // Parameterized confirmation query directly to the shared DB pool
            $user = DB::selectOne('SELECT id, role FROM users WHERE id = ?', [$decoded->sub]);

            if (!$user) {
                return response()->json(['error' => 'User no longer exists.'], 401);
            }

            // Check Role Constraints (RBAC) if any specified
            if (!empty($roles) && !in_array($user->role, $roles)) {
                return response()->json(['error' => 'Forbidden. Insufficient permissions.'], 403);
            }

            // Inject the user object parameters into the request context natively
            $request->attributes->set('auth_user', $user);

            return $next($request);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized. Invalid or expired token.'], 401);
        }
    }
}

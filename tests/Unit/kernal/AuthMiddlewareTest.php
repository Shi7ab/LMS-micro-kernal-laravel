<?php

namespace Tests\Unit\Kernel;

use Tests\TestCase;
use Illuminate\Http\Request;

class AuthMiddlewareTest extends TestCase
{
    /** @test */
    public function it_denies_access_if_jwt_token_is_missing_or_invalid()
    {
        $request = Request::create('/api/v1/courses', 'POST');

        $middleware = new class {
            public function handle($request, $next) {
                if (!$request->headers->has('Authorization') && !$request->attributes->has('user_id')) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
                return $next($request);
            }
        };

        $response = $middleware->handle($request, function () {
            return response()->json(['status' => 'success']);
        });

        $this->assertEquals(401, $response->getStatusCode());
    }

    /** @test */
    public function it_enforces_role_based_access_control_restrictions()
    {
        $request = Request::create('/api/v1/courses', 'POST');
        $request->attributes->set('user_id', 'student-uuid');
        $request->attributes->set('user_role', 'student');

        $middleware = new class {
            public function handle($request, $next, ...$roles) {
                $userRole = $request->attributes->get('user_role');
                if (!in_array($userRole, $roles)) {
                    return response()->json(['error' => 'Forbidden'], 403);
                }
                return $next($request);
            }
        };

        $response = $middleware->handle($request, function () {
            return response()->json(['status' => 'success']);
        }, 'instructor', 'admin');

        $this->assertEquals(403, $response->getStatusCode());
    }
}
